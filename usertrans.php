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

// Query to retrieve user-specific data from usertransactions table
$sql = "SELECT * FROM usertransactions WHERE manager_id = $manager_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions Data-Gately</title>
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
        <h1>Transactions Data</h1>
        <a class="btn btn-primary mb-3" href="#" data-toggle="modal" data-target="#addDataModal">New Transaction</a>
        <input style="width: 200px;" type="text" id="searchInput" class="form-control mb-3" placeholder="Search">

        <!-- Bootstrap table to display the data -->
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
            $rows_per_page = 10;
            $start = ($page - 1) * $rows_per_page;

            // Query to retrieve user-specific data from yourtable table
            $sql = "SELECT * FROM usertransactions WHERE manager_id = $manager_id LIMIT $start, $rows_per_page"; 
            $result = $conn->query($sql);

            echo "<table class='table table-striped'>
        <thead>
            <tr>
                <th>UserTelephone</th>
                <th>TransactionDate</th>
                <th>Description</th>
                <th>Description2</th>
                <th>Property</th>
                <th>Amount</th>
                <th>Actions</th> <!-- Add a new column for actions -->
            </tr>
        </thead>
        <tbody>";

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                <td>" . $row['UserTelephone'] . "</td>
                <td>" . $row['TransactionDate'] . "</td>
                <td>" . $row['Description'] . "</td>
                <td>" . $row['Description2'] . "</td>
                <td>" . $row['Property'] . "</td>
                <td>" . $row['Amount'] . "</td>
                <td>
                    <a href='#' data-toggle='modal' data-target='#editTransactionModal' data-id='" . $row['ID'] . "' data-telephone='" . $row['UserTelephone'] . "' data-date='" . $row['TransactionDate'] . "' data-description='" . $row['Description'] . "' data-description2='" . $row['Description2'] . "' data-property='" . $row['Property'] . "' data-amount='" . $row['Amount'] . "' class='btn btn-primary btn-sm'>Edit</a>
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
            <td></td>
        </tr>";
            }

            echo "</tbody>
      </table>";

            // Pagination
            $sql = "SELECT COUNT(*) as total FROM usertransactions WHERE manager_id = $manager_id"; 
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
    </div>

    <!-- Add Data Modal -->
    <div class="modal fade" id="addDataModal" tabindex="-1" role="dialog" aria-labelledby="addDataModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDataModalLabel">New Transaction</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="add_trans.php" method="post">
                        <div class="form-group mb-3">
                            <label for="UserTelephone">User Telephone</label>
                            <input type="text" class="form-control" id="UserTelephone" name="UserTelephone" required placeholder="User's payment N.O">
                        </div>
                        <div class="form-group mb-3">
                            <label for="TransactionDate">Transaction Date</label>
                            <input type="date" class="form-control" id="TransactionDate" name="TransactionDate" required placeholder="">
                        </div>
                        <div class="form-group mb-3">
                            <label for="Description">Description</label>
                            <input type="text" class="form-control" id="Description" name="Description" required placeholder="Add a description of payment">
                        </div>
                        <div class="form-group mb-3">
                            <label for="Description2">Description2</label>
                            <input type="text" class="form-control" id="Description2" name="Description2" placeholder="Additional description">
                        </div>
                        <div class="form-group mb-3">
                            <label for="Property">Property</label>
                            <input type="text" class="form-control" id="Property" name="Property" required placeholder="Property user belongs to">
                        </div>
                        <div class="form-group mb-3">
                            <label for="Amount">Amount</label>
                            <input type="text" class="form-control" id="Amount" name="Amount" required placeholder="Amount paid">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Add Transaction</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editTransactionModal" tabindex="-1" role="dialog" aria-labelledby="editTransactionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTransactionModalLabel">Edit Transaction</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="edit_transaction.php" method="post">
                        <input type="hidden" id="editTransactionID" name="editTransactionID" value="">
                        <div class="form-group">
                            <label for="editUserTelephone">User Telephone</label>
                            <input type="text" class="form-control" id="editUserTelephone" name="editUserTelephone" required>
                        </div>
                        <div class="form-group">
                            <label for="editTransactionDate">Transaction Date</label>
                            <input type="date" class="form-control" id="editTransactionDate" name="editTransactionDate" required>
                        </div>
                        <div class="form-group">
                            <label for="editDescription">Description</label>
                            <input type="text" class="form-control" id="editDescription" name="editDescription">
                        </div>
                        <div class="form-group">
                            <label for="editDescription2">Description 2</label>
                            <input type="text" class="form-control" id="editDescription2" name="editDescription2">
                        </div>
                        <div class="form-group">
                            <label for="editProperty">Property</label>
                            <input type="text" class="form-control" id="editProperty" name="editProperty">
                        </div>
                        <div class="form-group">
                            <label for="editAmount">Amount</label>
                            <input type="text" class="form-control" id="editAmount" name="editAmount">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
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

    <footer>
        <p>&copy; 2023 Gately System. All rights reserved.</p>
    </footer>
    <script src="app.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- JavaScript to Handle Modal -->
    <script>
        $('#deleteConfirmationModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var ID = button.data('id'); // Extract ID from data-id attribute
            var deleteButton = $(this).find('#deleteButton');

            // Update the delete button's href with the ID
            deleteButton.attr('href', 'delete_transaction.php?ID=' + ID);
        });
    </script>
    <script>
        $('#editTransactionModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var ID = button.data('id'); // Extract ID from data-id attribute
            var telephone = button.data('telephone');
            var date = button.data('date');
            var description = button.data('description');
            var description2 = button.data('description2');
            var property = button.data('property');
            var amount = button.data('amount');

            // Populate the edit form fields with the existing data
            var modal = $(this);
            modal.find('#editTransactionID').val(ID);
            modal.find('#editUserTelephone').val(telephone);
            modal.find('#editTransactionDate').val(date);
            modal.find('#editDescription').val(description);
            modal.find('#editDescription2').val(description2);
            modal.find('#editProperty').val(property);
            modal.find('#editAmount').val(amount);
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
            $("#searchInput").on("keyup", function() {
                var query = $(this).val();
                filterTableRows(query);
            });
        });
    </script>


</body>

</html>