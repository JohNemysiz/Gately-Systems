<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gately";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $ManagerCode = $_POST["ManagerCode"];
    $ManagerTelephone = $_POST["ManagerTelephone"];
    $ManagerName = $_POST["ManagerName"];
    $ManagerPassword = $_POST["ManagerPassword"];

    $sql = "UPDATE ManagerData
            SET ManagerTelephone = '$ManagerTelephone', ManagerName = '$ManagerName', ManagerPassword = '$ManagerPassword'
            WHERE ManagerCode = '$ManagerCode'";

    if ($conn->query($sql) === TRUE) {
        header("Location: admindshb.php"); // Redirect on success
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} elseif(isset($_GET["ManagerCode"])) {
    // Fetch existing manager data for editing
    $ManagerCode = $_GET["ManagerCode"];

    $sql = "SELECT * FROM ManagerData WHERE ManagerCode = '$ManagerCode'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $ManagerTelephone = $row["ManagerTelephone"];
        $ManagerName = $row["ManagerName"];
        $ManagerPassword = $row["ManagerPassword"];
    }
}
?>
