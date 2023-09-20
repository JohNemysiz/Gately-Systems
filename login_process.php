<?php
session_start();

// Function to sanitize input data
function sanitize_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// ... (Your PHP code for database handling)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize the input data
    $phone = sanitize_input($_POST['phone']);
    $password = sanitize_input($_POST['password']); // Add this line

    // Perform the database query (using PDO or MySQLi)
    // Replace the database credentials with your own
    $servername = "localhost";
    $username = "root";
    $password_db = ""; // Add your database password
    $dbname = "gately";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password_db);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "SELECT * FROM userdata WHERE UserTelephone1 = :phone";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':phone', $phone);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Phone number exists, check password
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row['TEMPlogin'] == $password) {
                // Password matches, redirect to dashboard.php
                $_SESSION['UserTelephone'] = $phone; // Store user's telephone in session
                header("Location: dashboard.php");
                exit();
            } else {
                // Password is incorrect, display error message
                $error_message = "Invalid phone number or password. Please try again.";
            }
        } else {
            // Phone number is not found, display error message
            $error_message = "Phone number not found. Please contact your manager.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}
?>
<!-- Rest of your HTML code remains the same -->
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-ABC123XYZ" crossorigin="anonymous">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Caprasimo&display=swap" rel="stylesheet">
<link rel="icon" href="pics/logo.png" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="style.css">

<head>
    <title>Login Status</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
        }

        footer {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
        }

        .additional-links {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .left-link,
        .right-link {
            text-decoration: none;
            color: blue;
        }

        .error-box {
            background: #F2DEDE;
            color: #A94442;
            padding: 10px;
            width: 95%;
            border-radius: 5px;
            margin: 20px auto;

        }

        #phoneInput {
            width: 279px;
        }

        .styled-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 12px;

        }
    </style>
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <a href="index.php" style="font-family: 'Caprasimo', cursive ,sans-serif;font-size: 29px;">Gately
                    Systems</a>
            </div>
            <ul class="nav-links">
                <li><a href="admin.php">Admin</a></li>
                <li><a href="manager.php">Manager</a></li>
                <li><a href="index.php">Home</a></li>
                <li><a href="mailto:info@gatelysystems.com">Contact</a></li>
            </ul>
            <div class="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </nav>
    </header>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="mt-3">
            <h1>Sign In</h1><br>
            <?php
            if (isset($error_message)) {
                echo "<div class='error-box'>$error_message</div>";
            }
            ?>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phoneInput" name="phone" class="styled-input">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="passwordInput" name="password" class="styled-input form-control" required>
                <input type="checkbox" id="showPassword">Show Password
                </label>

            </div>

            <button type="submit">Sign In</button>
        </form>
    </div>
    <footer>
        <p>&copy; 2023 Gately System. All rights reserved.</p>
    </footer>
    <script src="app.js"></script>
    <script>
        document.getElementById('showPassword').addEventListener('change', function() {
            var passwordInput = document.getElementById('passwordInput');
            if (this.checked) {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        });
    </script>
</body>

</html>