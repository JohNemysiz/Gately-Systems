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

$manager_id = $_SESSION['ManagerCode'];

$UserTelephone = $_POST['UserTelephone'];
$TransactionDate = $_POST['TransactionDate'];
$Description = $_POST['Description'];
$Description2 = $_POST['Description2'];
$Property = $_POST['Property'];
$Amount = $_POST['Amount'];

$sql = "INSERT INTO usertransactions (manager_id, UserTelephone, TransactionDate, Description, Description2, Property, Amount)
        VALUES ('$manager_id', '$UserTelephone', '$TransactionDate', '$Description', '$Description2', '$Property', '$Amount')";

if ($conn->query($sql) === TRUE) {
    header("Location: usertrans.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
