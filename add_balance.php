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

if (!isset($_SESSION['ManagerCode'])) {
    header("Location: login.php");
    exit();
}

$manager_id = $_SESSION['ManagerCode'];

// Assuming you have form fields named houseNumber, userName, userTelephone, balance, and treasuryProperty
$HouseNumber = $_POST['houseNumber'];
$UserName = $_POST['userName'];
$UserTelephone = $_POST['userTelephone'];
$Balance = $_POST['balance'];
$TreasuryProperty = $_POST['treasuryProperty'];

// Insert data into the 'balances' table
$sql = "INSERT INTO balances (HouseNumber, UserName, UserTelephone, Balance, TreasuryProperty, manager_id)
        VALUES ('$HouseNumber', '$UserName', '$UserTelephone', '$Balance', '$TreasuryProperty', '$manager_id')";

try {
    if ($conn->query($sql) === TRUE) {
        header("Location: userbalance.php");
        exit();
    } else {
        throw new Exception("Error: " . $sql . "<br>" . $conn->error);
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

$conn->close();
?>
