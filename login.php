<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gately";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$telephone = $_POST['telephone'];
$password = $_POST['password'];

// Validate user's credentials
$sql = "SELECT ManagerCode, ManagerName FROM ManagerData WHERE ManagerTelephone = '$telephone' AND ManagerPassword = '$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Authentication successful
    while($row = $result->fetch_assoc()) {
        $_SESSION['ManagerCode'] = $row['ManagerCode'];
        $_SESSION['ManagerName'] = $row['ManagerName'];
    }
    header("Location: managerdshb.php");
    exit();
} else {
    $conn->close();
    header("Location: manager.php?error=Incorrect phone number or password");
    exit();
}
?>
