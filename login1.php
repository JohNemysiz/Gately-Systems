
<?php
session_start();
include "db_conn.php";

if (isset($_POST['uname']) && isset($_POST['password'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);

    if (empty($uname)) {
        header("Location:admin.php?error=Phone number is required");
        exit();
    } else if (empty($pass)) {
        header("Location:admin.php?error=Password is required");
        exit();
    } else {
        $sql = "SELECT * FROM managerdata WHERE ManagerTelephone ='$uname' AND ManagerPassword='$pass'";

        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            // Check if ManagerName is "admin" (case-insensitive)
            if (strcasecmp($row['ManagerName'], 'admin') === 0) {
                $_SESSION['ManagerTelephone'] = $row['ManagerTelephone'];
                $_SESSION['ManagerCode'] = $row['ManagerCode'];
                header("Location: admindshb.php");
                exit();
            } else {
                header("Location: admin.php?error=You do not have admin access");
                exit();
            }
        } else {
            header("Location: admin.php?error=Incorrect Phone number or password");
            exit();
        }
    }
} else {
    header("Location:admin.php");
    exit();
}
?>