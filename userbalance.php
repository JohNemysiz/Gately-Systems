<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gately";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if a manager is logged in
if (!isset($_SESSION['ManagerCode'])) {
    header("Location: manager.php");
    exit();
}

$manager_id = $_SESSION['ManagerCode'];

$sql = "SELECT ID, HouseNumber, UserName, UserTelephone, Balance, TreasuryProperty FROM balances WHERE manager_id = $manager_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance Report-Gately</title>
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
        <h1>Balance Report</h1>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDataModal">
            Add New Data
        </button><br>
        <form class="form-inline mt-3">
            <div class="form-group">
                <input style="width:200px;" type="text" class="form-control" id="searchInput" placeholder="Search">
            </div>
        </form>
        <!-- Your HTML code and table structure -->
        <div class="table-responsive">
            <table class="table table-striped my-5">
                    <?php
                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $rows_per_page = 10;
                    $start = ($page - 1) * $rows_per_page;
                    
                    $sql = "SELECT ID, HouseNumber, UserName, UserTelephone, Balance, TreasuryProperty FROM balances WHERE manager_id = $manager_id LIMIT $start, $rows_per_page";
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
                                    <th>Actions</th>
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
                                    <td>
                                        <a href='#' data-toggle='modal' data-target='#editDataModal' data-id='" . $row['ID'] . "' class='btn btn-primary btn-sm editBtn'>Edit</a>
                                        <a href='#' data-toggle='modal' data-target='#deleteConfirmationModal' data-id='" . $row['ID'] . "' class='btn btn-danger btn-sm'>Delete</a>
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
                              </tr>";
                    }
                    
                    echo "</tbody>
                          </table>";
                    
                    // Pagination
                    $sql = "SELECT COUNT(*) as total FROM balances WHERE manager_id = $manager_id";
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
    <!-- Add New Data Modal -->
    <div class="modal fade" id="addDataModal" tabindex="-1" role="dialog" aria-labelledby="addDataModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDataModalLabel">Add New Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="add_balance.php" method="post">
                        <div class="form-group">
                            <label for="houseNumber">House Number:</label>
                            <input type="text" id="houseNumber" name="houseNumber" class="form-control" required placeholder="House N.O of User">
                        </div>
                        <div class="form-group mb-3">
                            <label for="userName">User Name:</label>
                            <input type="text" id="userName" name="userName" class="form-control" required placeholder="User Name of the payer">
                        </div>
                        <div class="form-group mb-3">
                            <label for="userTelephone">User Telephone:</label>
                            <input type="text" id="userTelephone" name="userTelephone" class="form-control" required placeholder="User's Telephone N.O">
                        </div>
                        <div class="form-group mb-3">
                            <label for="balance">Balance:</label>
                            <input type="text" id="balance" name="balance" class="form-control" required placeholder="User's Balance ">
                        </div>
                        <div class="form-group mb-3">
                            <label for="treasuryProperty">Treasury Property:</label>
                            <input type="text" id="treasuryProperty" name="treasuryProperty" class="form-control" required placeholder="Property the user belongs to">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- edit modal -->
    <div class="modal fade" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="editDataModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDataModalLabel">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="edit_balance.php" method="post" id="editForm">
                        <div class="form-group">
                            <label for="editHouseNumber">House Number:</label>
                            <input type="text" id="editHouseNumber" name="editHouseNumber" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="editUserName">User Name:</label>
                            <input type="text" id="editUserName" name="editUserName" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="editUserTelephone">User Telephone:</label>
                            <input type="text" id="editUserTelephone" name="editUserTelephone" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="editBalance">Balance:</label>
                            <input type="text" id="editBalance" name="editBalance" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="editTreasuryProperty">Treasury Property:</label>
                            <input type="text" id="editTreasuryProperty" name="editTreasuryProperty" class="form-control" required>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="editID" name="editID">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- The Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this transaction?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <a id="deleteButton" href="#" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>

</body>
<footer>
    <p>&copy; 2023 Gately System. All rights reserved.</p>
</footer>
<script src="app.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="script.js"></script>
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
<!-- JavaScript to Handle Edit and Delete Actions -->
<script>
    $(document).ready(function() {
        $('.editBtn').click(function() {
            var id = $(this).data('id');
            var houseNumber = $(this).closest('tr').find('td:nth-child(1)').text(); // Get House Number from the table row
            var userName = $(this).closest('tr').find('td:nth-child(2)').text(); // Get User Name from the table row
            var userTelephone = $(this).closest('tr').find('td:nth-child(3)').text(); // Get User Telephone from the table row
            var balance = $(this).closest('tr').find('td:nth-child(4)').text(); // Get Balance from the table row
            var treasuryProperty = $(this).closest('tr').find('td:nth-child(5)').text(); // Get Treasury Property from the table row

            // Set the values in the form fields
            $('#editID').val(id);
            $('#editHouseNumber').val(houseNumber);
            $('#editUserName').val(userName);
            $('#editUserTelephone').val(userTelephone);
            $('#editBalance').val(balance);
            $('#editTreasuryProperty').val(treasuryProperty);
        });
    });
</script>
<script>
    $('#deleteConfirmationModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var ID = button.data('id'); // Extract ID from data-id attribute
            var deleteButton = $(this).find('#deleteButton');

            // Update the delete button's href with the ID
            deleteButton.attr('href', 'delete_balance.php?ID=' + ID);
        });
</script>



</html>