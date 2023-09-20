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

    $ManagerTelephone = $_POST["ManagerTelephone"];
    $ManagerName = $_POST["ManagerName"];
    $ManagerPassword = $_POST["ManagerPassword"];

    $sql = "INSERT INTO ManagerData (ManagerTelephone, ManagerName, ManagerPassword)
            VALUES ('$ManagerTelephone', '$ManagerName', '$ManagerPassword')";

    if ($conn->query($sql) === TRUE) {
        header("Location: admindshb.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
