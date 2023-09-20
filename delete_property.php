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

    $sql = "DELETE FROM propertydata WHERE ID='$ID'";

    if ($conn->query($sql) === TRUE) {
        header("Location: managerdshb.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
