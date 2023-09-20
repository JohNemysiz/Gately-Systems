<?php
session_start();
include "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Validate form fields (phone, email, and password)
    $phone = validate($_POST['phone']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

    if (empty($phone)) {
        header("Location: signup.php?error=Phone number is required");
        exit();
    } elseif (empty($email)) {
        header("Location: signup.php?error=Email is required");
        exit();
    } elseif (empty($password)) {
        header("Location: signup.php?error=Password is required");
        exit();
    } elseif (strlen($password) !== 8) {
        header("Location: signup.php?error=Password must be exactly 8 characters");
        exit();
    } else {
        // Assuming you already have a database connection, replace 'DB_HOST', 'DB_USER', 'DB_PASS', and 'DB_NAME' with appropriate values.
        $conn = new mysqli('localhost', 'root', '', 'gately');

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Sanitize user inputs before inserting into the database to prevent SQL injection
        $phone = $conn->real_escape_string($phone);
        $email = $conn->real_escape_string($email);
        $password_hash = password_hash($password, PASSWORD_DEFAULT); // Hash the password before storing it in the database

        // Insert data into 'clients' table
        $insert_client_query = "INSERT INTO clients (phone, password) VALUES ('$phone', '$password_hash')";
        if ($conn->query($insert_client_query) === FALSE) {
            echo "Error inserting data into the 'clients' table: " . $conn->error;
            exit();
        }

        // Insert email into 'emails' table
        $insert_email_query = "INSERT INTO emails (email) VALUES ('$email')";
        if ($conn->query($insert_email_query) === FALSE) {
            echo "Error inserting data into the 'emails' table: " . $conn->error;
            exit();
        }

        // Close the database connection
        $conn->close();

        // Redirect to signin.php after successful registration
        header("Location: signin.php");
        exit();
    }
}
?>