<?php
session_start();

// Check if a manager is logged in
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

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];

    // Delete record from userdata table
    $stmt = $conn->prepare("DELETE FROM userdata WHERE ID = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Record deleted successfully

        // Reset auto-increment value
        $reset_auto_increment = "ALTER TABLE userdata AUTO_INCREMENT = 1";
        $conn->query($reset_auto_increment);

        $stmt->close();
        $conn->close();

        header("Location: userdata.php"); // Redirect back to userdata.php
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
