<?php
session_start();
$submittedUsername = $_POST['Username'];
$submittedPassword = $_POST['pw'];

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$sn = "sql212.infinityfree.com";
$un = "if0_35086558";
$pw = "G0sBOo8WAx";
$dbName = "if0_35086558_users";

$conn = new mysqli($sn, $un, $pw, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT Username, Password FROM users WHERE Username = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error in SQL query: " . $conn->error);
}
$stmt->bind_param("s", $submittedUsername);
if ($stmt->execute()) {
    $stmt->bind_result($dbUsername, $dbPassword);
    $stmt->fetch();
    $stmt->close();

    if ($submittedPassword === $dbPassword) { 
        $_SESSION['user_id'] = $username;
        header("Location: /subjects.html");
    } else {
        echo "Invalid username or password.";
    }
} else {
    die("Error in SQL query: " . $conn->error);
}

$conn->close();
?>
