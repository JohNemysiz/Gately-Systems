<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gately";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$ManagerCode = $_POST['ManagerCode'];

// Delete manager
$sqlDelete = "DELETE FROM ManagerData WHERE ManagerCode = '$ManagerCode'";
if ($conn->query($sqlDelete) === TRUE) {
    echo "Manager deleted successfully";

    // Update ManagerCode values
    $sqlUpdate = "SET @count = 0;
                  UPDATE ManagerData SET ManagerCode = @count:= @count + 1;
                  ALTER TABLE ManagerData AUTO_INCREMENT = @count + 1;";
    if ($conn->multi_query($sqlUpdate) === TRUE) {
        echo "ManagerCode values updated successfully";
    } else {
        echo "Error updating ManagerCode values: " . $conn->error;
    }
} else {
    echo "Error deleting manager: " . $conn->error;
}

$conn->close();

header("Location: admindshb.php");
exit();
?>
