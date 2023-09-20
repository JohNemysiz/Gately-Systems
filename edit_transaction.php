<?php
session_start();

if (!isset($_SESSION['ManagerCode'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gately";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$transaction_id = $_POST['editTransactionID'];
$UserTelephone = $_POST['editUserTelephone'];
$TransactionDate = $_POST['editTransactionDate'];
$Description = $_POST['editDescription'];
$Description2 = $_POST['editDescription2'];
$Property = $_POST['editProperty'];
$Amount = $_POST['editAmount'];

$sql = "UPDATE usertransactions 
        SET UserTelephone='$UserTelephone', 
            TransactionDate='$TransactionDate', 
            Description='$Description', 
            Description2='$Description2', 
            Property='$Property', 
            Amount='$Amount' 
        WHERE ID='$transaction_id'";

if ($conn->query($sql) === TRUE) {
    header("Location: usertrans.php");
    exit();
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>