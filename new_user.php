

<!--// session start here...
// get all 3 strings from the form (and scrub w/ validation function)
// make sure that the two password values match!
// create the password_hash using the PASSWORD_DEFAULT argument
// login to the database
// make sure that the new user is not already in the database
// insert username and password hash into db (put the username in the session
// or make them login)-->
<?php
session_start();

include_once 'validate.php';
$user = test_input($_POST['user']);
$userPwd = test_input($_POST['pwd']);
$repeatPwd = test_input($_POST['repeat']);

if ($userPwd == $repeatPwd) {
    $pwd = password_hash($userPwd, PASSWORD_DEFAULT);
} else {
    header("location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "softball";

// Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $userNameCheck = $conn->query("SELECT * FROM users WHERE username = '$user'");

        if ($userNameCheck->num_rows > 0) {
            echo "Username is already being used";
            echo "<br>";
            echo "<a href='register.php'>Register Again</a>";
            exit;
        }

        $sql = "INSERT INTO users (username, password)
VALUES ('$user', '$pwd')";

        if ($conn->query($sql) === TRUE) {
            echo "New account created successfully";
            $_SESSION['username'] = $user;
            $_SESSION['error'] = '';
            echo"<br>";
            echo "<a href='index.php'>Main Menu</a>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
        ?>
        <br>


    </body>
</html>