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

$ID = $_POST['editID'];
$HouseNumber = $_POST['editHouseNumber'];
$UserName = $_POST['editUserName'];
$UserTelephone = $_POST['editUserTelephone'];
$Balance = $_POST['editBalance'];
$TreasuryProperty = $_POST['editTreasuryProperty'];

$sql = "UPDATE balances SET HouseNumber='$HouseNumber', UserName='$UserName', UserTelephone='$UserTelephone',
        Balance='$Balance', TreasuryProperty='$TreasuryProperty'
        WHERE ID='$ID' AND manager_id='$manager_id'";

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
