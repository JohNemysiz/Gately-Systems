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

$PropertyName = $_POST['PropertyName'];
$PropertyType = $_POST['PropertyType'];
$NameOfUsersSINGLE = $_POST['NameOfUsersSINGLE'];
$NameOfUsersPLURAL = $_POST['NameOfUsersPLURAL'];
$NameOfPaymentsSINGLE = $_POST['NameOfPaymentsSINGLE'];
$NameOfPaymentsPLURAL = $_POST['NameOfPaymentsPLURAL'];
$NeighborDataType = $_POST['NeighborDataType'];
$DefaultCurrency = $_POST['DefaultCurrency'];
$ManagerCode = $_POST['ManagerCode'];  // This is the hidden input field we added

$sql = "INSERT INTO propertydata (PropertyName, PropertyType, NameOfUsersSINGLE, NameOfUsersPLURAL, NameOfPaymentsSINGLE, NameOfPaymentsPLURAL, NeighborDataType, DefaultCurrency, ManagerCode)
VALUES ('$PropertyName', '$PropertyType', '$NameOfUsersSINGLE', '$NameOfUsersPLURAL', '$NameOfPaymentsSINGLE', '$NameOfPaymentsPLURAL', '$NeighborDataType', '$DefaultCurrency', '$ManagerCode')";

if ($conn->query($sql) === TRUE) {
    header("Location: managerdshb.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
