<?php
session_start();

if (!isset($_SESSION['ManagerCode'])) {
    header("Location: manager.php");
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ID = $_POST['PropertyID'];
    $PropertyName = $_POST['PropertyName'];
    $PropertyType = $_POST['PropertyType'];
    $NeighborDataType = $_POST['NeighborDataType'];
    $NameOfUsersSingle = $_POST['NameOfUsersSINGLE'];
    $NameOfUsersPlural = $_POST['NameOfUsersPLURAL'];
    $NameOfPaymentsSingle = $_POST['NameOfPaymentsSINGLE'];
    $NameOfPaymentsPlural = $_POST['NameOfPaymentsPLURAL'];

    $sql = "UPDATE propertydata SET 
            PropertyName='$PropertyName', 
            PropertyType='$PropertyType', 
            NeighborDataType='$NeighborDataType',
            NameOfUsersSINGLE='$NameOfUsersSingle',
            NameOfUsersPLURAL='$NameOfUsersPlural',
            NameOfPaymentsSINGLE='$NameOfPaymentsSingle',
            NameOfPaymentsPLURAL='$NameOfPaymentsPlural'
            WHERE ID='$ID'";

    if ($conn->query($sql) === TRUE) {
        header("Location: managerdshb.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
