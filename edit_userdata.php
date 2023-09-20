<?php
session_start();

if (!isset($_SESSION['ManagerCode'])) {
    header("Location: login.php");
    exit();
}

$manager_id = $_SESSION['ManagerCode'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gately";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['EditID'];
    $House = $_POST['EditHouse'];
    $UserName = $_POST['EditUserName'];
    $UserPaymentsName = $_POST['EditUserPaymentsName'];
    $Active = $_POST['EditActive'];
    $UserTelephone1 = $_POST['EditUserTelephone1'];
    $UserTelephone2 = $_POST['EditUserTelephone2'];
    $TEMPlogin = $_POST['EditTEMPlogin'];
    $PropertyName = $_POST['EditPropertyName'];

    $sql = "UPDATE userdata SET 
            House = '$House',
            UserName = '$UserName',
            UserPaymentsName = '$UserPaymentsName',
            Active = '$Active',
            UserTelephone1 = '$UserTelephone1',
            UserTelephone2 = '$UserTelephone2',
            TEMPlogin = '$TEMPlogin',
            PropertyName = '$PropertyName'
            WHERE ID = $id AND PropertyUser = $manager_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: userdata.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
