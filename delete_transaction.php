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

$transaction_id = $_GET['ID'];

$sql = "DELETE FROM usertransactions WHERE ID = $transaction_id";

if ($conn->query($sql) === TRUE) {
    // Reset auto-increment
    $resetAutoIncrement = "ALTER TABLE usertransactions AUTO_INCREMENT = 1";
    if ($conn->query($resetAutoIncrement) === TRUE) {
        header("Location: usertrans.php");
        exit();
    } else {
        echo "Error resetting auto-increment: " . $conn->error;
    }
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>
