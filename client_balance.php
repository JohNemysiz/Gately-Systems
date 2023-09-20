<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['UserTelephone'])) {
    header("Location: login_process.php"); // Redirect to login page if not logged in
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

$userTelephone = $_SESSION['UserTelephone']; // Get user's telephone from session

$sql = "SELECT * FROM balances WHERE UserTelephone = '$userTelephone'";
$result = $conn->query($sql);

// Fetch user details from userdata table
$userDetailsQuery = "SELECT UserName, House, PropertyName FROM userdata WHERE UserTelephone1 = '$userTelephone'";
$userDetailsResult = $conn->query($userDetailsQuery);

if ($userDetailsResult->num_rows > 0) {
    $userDetails = $userDetailsResult->fetch_assoc();
    $userName = $userDetails['UserName'];
    $houseNumber = $userDetails['House'];
    $propertyName = $userDetails['PropertyName'];
} else {
    // Handle case where user details are not found
    $userName = "User";
    $houseNumber = "N/A";
    $propertyName = "N/A";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Balances - Gately</title>
    <link rel="icon" href="pics/logo.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caprasimo&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-ABC123XYZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="classic.css">
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <a href="index.php" style="font-family: 'Caprasimo', cursive ,sans-serif;font-size: 29px;">Gately
                    Systems</a>
            </div>
            <ul class="nav-links">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
            <div class="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </nav>
    </header>
    <div class="container my-5">
        <div class="header-container">
            <h1>Balances</h1>
            <div class="welcome-message">
                <h2>Welcome, <?php echo $userName; ?>!</h2>
                <h2> <?php echo $propertyName; ?></h2>
                <h2 style="font-size: 16px;"><?php echo $houseNumber; ?></h2>
            </div>
        </div>
        <div class="table-responsive">
                    <?php
                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $rows_per_page = 10;
                    $start = ($page - 1) * $rows_per_page;
                    
                    $sql = "SELECT * FROM balances WHERE UserTelephone = '$userTelephone' LIMIT $start, $rows_per_page";
                    $result = $conn->query($sql);
                    
                    // ... (existing code)
                    
                    echo "<table class='table table-striped my-5'>
                            <thead>
                                <tr>
                                    <th>House Number</th>
                                    <th>User Name</th>
                                    <th>User Telephone</th>
                                    <th>Balance</th>
                                    <th>Treasury Property</th>
                                </tr>
                            </thead>
                            <tbody>";
                    
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['HouseNumber']}</td>
                                    <td>{$row['UserName']}</td>
                                    <td>{$row['UserTelephone']}</td>
                                    <td>{$row['Balance']}</td>
                                    <td>{$row['TreasuryProperty']}</td>
                                  </tr>";
                        }
                    } else {
                        // Output an empty row with column names
                        echo "<tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                              </tr>";
                    }
                    
                    echo "</tbody>
                          </table>";
                    
                    // Pagination
                    $sql = "SELECT COUNT(*) as total FROM balances WHERE UserTelephone = '$userTelephone'";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $total_rows = $row['total'];
                    $total_pages = ceil($total_rows / $rows_per_page);
                    
                    echo "<nav aria-label='Page navigation'>
                            <ul class='pagination'>";
                    
                    for ($i = 1; $i <= $total_pages; $i++) {
                        echo "<li class='page-item " . ($i == $page ? 'active' : '') . "'><a class='page-link' href='?page=$i'>$i</a></li>";
                    }
                    
                    echo "</ul>
                          </nav>";
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <footer>
        <p>&copy; 2023 Gately System. All rights reserved.</p>
    </footer>
    <script src="app.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</body>

</html>