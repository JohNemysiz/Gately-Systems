<?php
session_start();

// Check if a manager is logged in
if (!isset($_SESSION['ManagerCode'])) {
    header("Location: manager.php");
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
// Query to retrieve user-specific data from userdata table
$sql = "SELECT * FROM userdata WHERE PropertyUser = $manager_id";
$result = $conn->query($sql);

// ...
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $House = $_POST['House'];
    $UserName = $_POST['UserName'];
    $UserPaymentsName = $_POST['UserPaymentsName'];
    $Active = $_POST['Active'];
    $UserTelephone1 = $_POST['UserTelephone1'];
    $UserTelephone2 = $_POST['UserTelephone2'];
    $TEMPlogin = $_POST['TEMPlogin'];
    $PropertyName = $_POST['PropertyName'];

    // Use prepared statement to avoid SQL injection
    $stmt = $conn->prepare("INSERT INTO userdata (`House`, `UserName`, `UserPaymentsName`, `Active`, `UserTelephone1`, `UserTelephone2`, `TEMPlogin`, `PropertyUser`, `PropertyName`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $House, $UserName, $UserPaymentsName, $Active, $UserTelephone1, $UserTelephone2, $TEMPlogin, $manager_id, $PropertyName);

    if ($stmt->execute()) {
        // Data inserted successfully
        header("Location: userdata.php"); // Redirect to manager dashboard
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
// ...
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Data-Gately</title>
    <link rel="icon" href="pics/logo.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caprasimo&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-ABC123XYZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script defer src="script.js"></script>
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
                <li><a href="index.php">Home</a></li>
                <li class="sign-up"><a href="managerdshb.php">Go Back</a></li>

                <li class="sign-up"><a href="logoutm.php">Logout</a></li>
            </ul>
            <div class="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </nav>
    </header>
    <div class="container my-5">
        <h1>User Data</h1>
        <a class="btn btn-primary" href="#" role="button" data-toggle="modal" data-target="#addDataModal">New Data</a><br><br>
        <input style="width: 200px;" type="text" id="searchInput" class="form-control mb-3" placeholder="Search">

        <div class="table-responsive">
            <?php

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

            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $rows_per_page = 12;
            $start = ($page - 1) * $rows_per_page;

            // Query to retrieve user-specific data from userdata table
            $sql = "SELECT * FROM userdata WHERE PropertyUser = $manager_id LIMIT $start, $rows_per_page";
            $result = $conn->query($sql);

                echo "<table class='table table-striped my-5'>
            <thead>
                <tr>
                    <th>House#</th>
                    <th>UserName</th>
                    <th>UserPaymentsName</th>
                    <th>Active</th>
                    <th>UserTelephone#1</th>
                    <th>UserTelephone#2</th>
                    <th>TEMPlogin#</th>
                    <th>PropertyName</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>";
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                <td>{$row['House']}</td>
                <td>{$row['UserName']}</td>
                <td>{$row['UserPaymentsName']}</td>
                <td>{$row['Active']}</td>
                <td>{$row['UserTelephone1']}</td>
                <td>{$row['UserTelephone2']}</td>
                <td>{$row['TEMPlogin']}</td>
                <td>{$row['PropertyName']}</td>
                <td>
                    <a href='#' data-toggle='modal' data-target='#editDataModal'
                        data-id='{$row['ID']}'
                        data-house='{$row['House']}'
                        data-username='{$row['UserName']}'
                        data-payments='{$row['UserPaymentsName']}'
                        data-active='{$row['Active']}'
                        data-telephone1='{$row['UserTelephone1']}'
                        data-telephone2='{$row['UserTelephone2']}'
                        data-templogin='{$row['TEMPlogin']}'
                        data-propertyname='{$row['PropertyName']}'
                        class='btn btn-primary btn-sm editBtn'>Edit</a>
                    <a href='#' data-toggle='modal' data-target='#deleteConfirmationModal' data-id='{$row['ID']}' class='btn btn-danger btn-sm deleteBtn'>Delete</a>
                </td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>";
            }
            
            echo "</tbody>
                  </table>";
            
            // Pagination
            $sql = "SELECT COUNT(*) as total FROM userdata WHERE PropertyUser = $manager_id";
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
            
            $conn->close();
            ?>

        </div>
        <!-- Add new data modal -->
        <div class="modal fade" id="addDataModal" tabindex="-1" role="dialog" aria-labelledby="addDataModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDataModalLabel">Add New Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="modal-body">
                            <!-- Add form fields for all columns except foreign key and ID -->
                            <div class="form-group mb-3">
                                <label for="House">House Number</label>
                                <input type="text" class="form-control" id="House" name="House" required placeholder="Enter the Users house N.O">
                            </div>
                            <div class="form-group mb-3">
                                <label for="UserName">User Name</label>
                                <input type="text" class="form-control" id="UserName" name="UserName" required placeholder="Enter the Users Name">
                            </div>
                            <div class="form-group mb-3">
                                <label for="UserPaymentsName">User Payments Name</label>
                                <input type="text" class="form-control" id="UserPaymentsName" name="UserPaymentsName" required placeholder="Enter the Users payment name">
                            </div>
                            <div class="form-group mb-3">
                                <label for="Active">Active</label>
                                <select class="form-control" id="Active" name="Active" required>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="UserTelephone1">User Telephone 1</label>
                                <input type="text" class="form-control" id="UserTelephone1" name="UserTelephone1" required placeholder="Enter the Users Alternative Number">
                            </div>
                            <div class="form-group mb-3">
                                <label for="UserTelephone2">User Telephone 2</label>
                                <input type="text" class="form-control" id="UserTelephone2" name="UserTelephone2" required placeholder="Enter the Users Alternative Number 2">
                            </div>
                            <div class="form-group mb-3">
                                <label for="TEMPlogin">TEMP Login</label>
                                <input type="text" class="form-control" id="TEMPlogin" name="TEMPlogin" required placeholder="Enter the Users Login Password">
                            </div>
                            <div class="form-group ">
                                <label for="PropertyName">Property Name</label>
                                <input type="text" class="form-control" id="PropertyName" name="PropertyName" required placeholder="Enter the Users residence">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save Data</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Add edit data modal -->
    <div class="modal fade" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="editDataModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDataModalLabel">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="edit_userdata.php" method="post">
                    <div class="modal-body">
                        <!-- Add form fields for editing data -->
                        <input type="hidden" id="EditID" name="EditID">
                        <div class="form-group mb-3">
                            <label for="EditHouse">House Number</label>
                            <input type="text" class="form-control" id="EditHouse" name="EditHouse" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="EditUserName">User Name</label>
                            <input type="text" class="form-control" id="EditUserName" name="EditUserName" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="EditUserPaymentsName">User Payments Name</label>
                            <input type="text" class="form-control" id="EditUserPaymentsName" name="EditUserPaymentsName" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="EditActive">Active</label>
                            <select class="form-control" id="EditActive" name="EditActive" required>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="EditUserTelephone1">User Telephone 1</label>
                            <input type="text" class="form-control" id="EditUserTelephone1" name="EditUserTelephone1" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="EditUserTelephone2">User Telephone 2</label>
                            <input type="text" class="form-control" id="EditUserTelephone2" name="EditUserTelephone2" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="EditTEMPlogin">TEMP Login</label>
                            <input type="text" class="form-control" id="EditTEMPlogin" name="EditTEMPlogin" required>
                        </div>
                        <div class="form-group">
                            <label for="EditPropertyName">Property Name</label>
                            <input type="text" class="form-control" id="EditPropertyName" name="EditPropertyName" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete confirmation modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this data?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <a id="deleteLink" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>





    <footer>
        <p>&copy; 2023 Gately System. All rights reserved.</p>
    </footer>
    <script src="app.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Handle delete button click
            $('.deleteBtn').click(function() {
                var id = $(this).data('id');
                var deleteLink = "delete_userdata.php?id=" + id; // Replace "delete.php" with your actual delete script

                // Set the delete link dynamically
                $('#deleteLink').attr('href', deleteLink);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Function to filter the table rows based on the search query
            function filterTableRows(query) {
                var table = $(".table");
                var rows = table.find("tr").slice(1); // Skip the table header row

                rows.hide(); // Hide all rows first

                rows.filter(function() {
                    // Check if any cell in the row contains the search query
                    return $(this).text().toLowerCase().includes(query.toLowerCase());
                }).show(); // Show matching rows
            }

            // Event listener for the search input field
            $("#searchInput").on("input", function() {
                var query = $(this).val();
                filterTableRows(query);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Handle edit button click
            $('.editBtn').click(function() {
                var id = $(this).data('id');
                $('#EditID').val(id);

                // Populate form fields
                $('#EditHouse').val($(this).data('house'));
                $('#EditUserName').val($(this).data('username'));
                $('#EditUserPaymentsName').val($(this).data('payments'));
                $('#EditActive').val($(this).data('active'));
                $('#EditUserTelephone1').val($(this).data('telephone1'));
                $('#EditUserTelephone2').val($(this).data('telephone2'));
                $('#EditTEMPlogin').val($(this).data('templogin'));
                $('#EditPropertyName').val($(this).data('propertyname'));
            });
        });
    </script>
</body>

</html>