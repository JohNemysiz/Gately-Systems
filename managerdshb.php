<?php
session_start();

if (!isset($_SESSION['ManagerCode'])) {
    header("Location: manager.php");
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

$managerCode = $_SESSION['ManagerCode'];

// Query to get the manager's name
$getNameSql = "SELECT ManagerName FROM managerdata WHERE ManagerCode = $managerCode";
$nameResult = $conn->query($getNameSql);

if ($nameResult->num_rows == 1) {
    $row = $nameResult->fetch_assoc();
    $managerName = $row['ManagerName'];
} else {
    // Handle error if name is not found
    $managerName = "Unknown Manager";
}

$sql = "SELECT * FROM propertydata WHERE ManagerCode = $managerCode";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard - Gately Systems</title>
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
                <li class="sign-up"><a href="userdata.php">Data</a></li>
                <li class="sign-up"><a href="usertrans.php">Transactions</a></li>
                <li class="sign-up"><a href="userbalance.php">Balances</a></li>
                <li class="sign-up"><a href="logoutm.php">Logout</a></li>

            </ul>
            <div class="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </nav>
    </header>

    <main>
        <div class="container my-5">
            <div class="header-container">
                <h1>Property Data</h1>
                <h2>Welcome, <?php echo $managerName; ?></h2>
            </div><br>
            <button class="btn btn-primary" data-toggle="modal" data-target="#addPropertyModal">Add New Property</button><br>

            <form class="form-inline mt-3">
                <div class="form-group">
                    <input type="text" class="form-control" id="searchInput" placeholder="Search" style="width: 200px;">

                </div>

            </form>

            <div class="table-responsive">
                <table class="table table-striped my-5">
                    <thead>
                        <tr>
                            <th>PROPERTY NAME</th>
                            <th>Property Type</th>
                            <th>Name Of Users (SINGLE)</th>
                            <th>Name Of Users (PLURAL)</th>
                            <th>Name Of Payments (SINGLE)</th>
                            <th>Name Of Payments (PLURAL)</th>
                            <th>Neighbor Data Type</th>
                            <th>Default Currency</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
            <td>{$row['PropertyName']}</td>
            <td>{$row['PropertyType']}</td>
            <td>{$row['NameOfUsersSINGLE']}</td>
            <td>{$row['NameOfUsersPLURAL']}</td>
            <td>{$row['NameOfPaymentsSINGLE']}</td>
            <td>{$row['NameOfPaymentsPLURAL']}</td>
            <td>{$row['NeighborDataType']}</td>
            <td>{$row['DefaultCurrency']}</td>
            <td>
                <div class='d-flex'>
                    <button class='btn btn-primary btn-sm editPropertyBtn mx-0.5' 
                        data-toggle='modal' 
                        data-target='#editPropertyModal' 
                        data-id='{$row['ID']}'
                        data-propertyname='{$row['PropertyName']}'
                        data-propertytype='{$row['PropertyType']}'
                        data-nameofuserssingle='{$row['NameOfUsersSINGLE']}'
                        data-nameofusersplural='{$row['NameOfUsersPLURAL']}'
                        data-nameofpaymentssingle='{$row['NameOfPaymentsSINGLE']}'
                        data-nameofpaymentsplural='{$row['NameOfPaymentsPLURAL']}'
                        data-neighbordatatype='{$row['NeighborDataType']}'
                        data-defaultcurrency='{$row['DefaultCurrency']}'>Edit
                    </button>
                    <button class='btn btn-danger btn-sm deletePropertyBtn mx-1' 
                        data-toggle='modal' 
                        data-target='#deletePropertyModal' 
                        data-id='{$row['ID']}'>Delete</button>
                </div>
            </td>
        </tr>";
                            }
                        }
                        ?>

                    </tbody>
                </table>
            </div>


            <!-- Add Property Modal -->
            <div class="modal fade" id="addPropertyModal" tabindex="-1" role="dialog" aria-labelledby="addPropertyModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addPropertyModalLabel">Add New Property</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="add_property.php" method="post">
                                <div class="form-group mb-3">
                                    <label for="PropertyName">Property Name</label>
                                    <input type="text" class="form-control" id="PropertyName" name="PropertyName" required placeholder="Property Name">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="PropertyType">Property Type</label>
                                    <input type="text" class="form-control" id="PropertyType" name="PropertyType" required placeholder="Property Type">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="NameOfUsersSINGLE">Name Of Users (single)</label>
                                    <input type="text" class="form-control" id="NameOfUsersSINGLE" name="NameOfUsersSINGLE" required placeholder="E.g Tenant">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="NameOfUsersPLURAL">Name Of Users (Plural)</label>
                                    <input type="text" class="form-control" id="NameOfUsersPLURAL" name="NameOfUsersPLURAL" required placeholder="E.g Tenants">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="NameOfPaymentsSINGLE">Name Of Payments (single)</label>
                                    <input type="text" class="form-control" id="NameOfPaymentsSINGLE" name="NameOfPaymentsSINGLE" required placeholder="E.g Rent">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="NameOfPaymentsPLURAL">Name Of Payments (Plural)</label>
                                    <input type="text" class="form-control" id="NameOfPaymentsPLURAL" name="NameOfPaymentsPLURAL" required placeholder="E.g Rents">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="NeighborDataType">Neighbor Data Type</label>
                                    <input type="text" class="form-control" id="NeighborDataType" name="NeighborDataType" required placeholder="Neighbor Data Type">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="DefaultCurrency">Default Currency</label>
                                    <input type="text" class="form-control" id="DefaultCurrency" name="DefaultCurrency" required placeholder="Default Currency">
                                </div>
                                <input type="hidden" name="ManagerCode" value="<?php echo $_SESSION['ManagerCode']; ?>"><!-- Add more form fields as needed -->
                                <button type="submit" class="btn btn-primary">Add Property</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Property Modal -->
        <div class="modal fade" id="editPropertyModal" tabindex="-1" role="dialog" aria-labelledby="editPropertyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPropertyModalLabel">Edit Property Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="edit_property.php" method="post">
                            <div class='form-group mb-3'>
                                <label for='editPropertyName'>Property Name</label>
                                <input type="text" class="form-control" id="editPropertyName" name="PropertyName" value="<?php echo $row['PropertyName']; ?>" required>

                            </div>
                            <div class='form-group mb-3'>
                                <label for='editPropertyType'>Property Type</label>
                                <input type='text' class='form-control' id='editPropertyType' name='PropertyType' value="<?php echo $row['PropertyType']; ?>" required>
                            </div>
                            <div class='form-group mb-3'>
                                <label for='editNameOfUsersSINGLE'>Name of Users (Single)</label>
                                <input type='text' class='form-control' id='editNameOfUsersSINGLE' name='NameOfUsersSINGLE' value="<?php echo $row['NameOfUsersSINGLE']; ?>" required>
                            </div>
                            <div class='form-group mb-3'>
                                <label for='editNameOfUsersPLURAL'>Name of Users (Plural)</label>
                                <input type='text' class='form-control' id='editNameOfUsersPLURAL' name='NameOfUsersPLURAL' value="<?php echo $row['NameOfUsersPLURAL']; ?>" required>
                            </div>
                            <div class='form-group mb-3'>
                                <label for='editNameOfPaymentsSINGLE'>Name of Payments (Single)</label>
                                <input type='text' class='form-control' id='editNameOfPaymentsSINGLE' name='NameOfPaymentsSINGLE' value="<?php echo $row['NameOfPaymentsSINGLE']; ?>" required>
                            </div>
                            <div class='form-group mb-3'>
                                <label for='editNameOfPaymentsPLURAL'>Name of Payments (Plural)</label>
                                <input type='text' class='form-control' id='editNameOfPaymentsPLURAL' name='NameOfPaymentsPLURAL' value="<?php echo $row['NameOfPaymentsPLURAL']; ?>" required>
                            </div>
                            <div class='form-group mb-3'>
                                <label for='editNeighborDataType'>Neighbor Data Type</label>
                                <input type='text' class='form-control' id='editNeighborDataType' name='NeighborDataType' value="<?php echo $row['NeighborDataType']; ?>" required>
                            </div>
                            <div class='form-group mb-3'>
                                <label for='editDefaultCurrency'>Default Currency</label>
                                <input type='text' class='form-control' id='editDefaultCurrency' name='DefaultCurrency' value="<?php echo $row['DefaultCurrency']; ?>" required>
                            </div>
                            <input type='hidden' id='editPropertyID' name='PropertyID'>
                            <button type='submit' class='btn btn-primary'>Save Changes</button>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Delete Property Modal -->
        <div class="modal fade" id="deletePropertyModal" tabindex="-1" role="dialog" aria-labelledby="deletePropertyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deletePropertyModalLabel">Delete Property Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this property?</p>
                        <form action="delete_property.php" method="post">
                            <input type="hidden" id="deletePropertyID" name="PropertyID">
                            <button type="submit" class="btn btn-danger">Delete</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Gately System. All rights reserved.</p>
    </footer>
    <script src="app.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<script>
    $(document).ready(function() {
        $('.editPropertyBtn').click(function() {
            var id = $(this).data('id');
            var propertyName = $(this).data('propertyname');
            var propertyType = $(this).data('propertytype');
            var nameOfUsersSingle = $(this).data('nameofuserssingle');
            var nameOfUsersPlural = $(this).data('nameofusersplural');
            var nameOfPaymentsSingle = $(this).data('nameofpaymentssingle');
            var nameOfPaymentsPlural = $(this).data('nameofpaymentsplural');
            var neighborDataType = $(this).data('neighbordatatype');
            var defaultCurrency = $(this).data('defaultcurrency');

            $('#editPropertyID').val(id);
            $('#editPropertyName').val(propertyName);
            $('#editPropertyType').val(propertyType);
            $('#editNameOfUsersSINGLE').val(nameOfUsersSingle);
            $('#editNameOfUsersPLURAL').val(nameOfUsersPlural);
            $('#editNameOfPaymentsSINGLE').val(nameOfPaymentsSingle);
            $('#editNameOfPaymentsPLURAL').val(nameOfPaymentsPlural);
            $('#editNeighborDataType').val(neighborDataType);
            $('#editDefaultCurrency').val(defaultCurrency);
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.deletePropertyBtn').click(function() {
            var id = $(this).data('id');
            $('#deletePropertyID').val(id);
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
</body>

</html>