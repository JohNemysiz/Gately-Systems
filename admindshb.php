<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Propertydata-Gately</title>
    <link rel="icon" href="pics/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caprasimo&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-ABC123XYZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script defer src="script.js"></script>
    <script defer src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="classic.css">
</head>
<style>
    #downloadLink {
        color: white;
        text-decoration: underline;
        cursor: pointer;
    }
</style>

<body>
    <header>
        <nav>
            <div class="logo">
                <a href="index.php" style="font-family: 'Caprasimo', cursive ,sans-serif;font-size: 29px;">Gately
                    Systems</a>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li class="sign-up"><a href="logout2.php">Logout</a></li>
            </ul>
            <div class="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </nav>
    </header>
    <div class="container my-5">
        <h1>Manager Data</h1>
        <div class="boot2">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addManagerModal">Add New Manager</button>
        </div>
        <form class="form-inline mt-3">
            <div class="form-group">
                <input type="text" class="form-control" id="searchInput" placeholder="Search">
            </div>

        </form>
        <div class="table-responsive">
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "gately";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $page = isset($_GET['page']) ? $_GET['page'] : 1; // Get the current page number or set it to 1 if not set
            $rows_per_page = 7;
            $start = ($page - 1) * $rows_per_page;

            $sql = "SELECT * FROM ManagerData LIMIT $start, $rows_per_page";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table class='table table-striped my-5'>
            <thead>
                <tr>
                    <th>ManagerTelephone#</th>
                    <th>ManagerName</th>
                    <th>ManagerPassword</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                <td>{$row['ManagerTelephone']}</td>
                <td>{$row['ManagerName']}</td>
                <td>{$row['ManagerPassword']}</td>
                <td>
                    <button class='btn btn-primary btn-sm' data-toggle='modal' data-target='#editManagerModal{$row['ManagerCode']}'>Edit</button>
                    <button class='btn btn-danger btn-sm' data-toggle='modal' data-target='#deleteManagerModal{$row['ManagerCode']}'>Delete</button>
                </td>
            </tr>";
                }

                echo "</tbody>
          </table>";

                // Pagination
                $sql = "SELECT COUNT(*) as total FROM ManagerData";
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
            }

            $conn->close();
            ?>
        </div>
    </div>

    <!-- Add Manager Modal -->
    <div class="modal fade" id="addManagerModal" tabindex="-1" role="dialog" aria-labelledby="addManagerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addManagerModalLabel">Add New Manager</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="add_manager.php" method="post">
                        <div class="form-group">
                            <label for="ManagerTelephone">Telephone Number</label>
                            <input type="text" class="form-control" id="ManagerTelephone" name="ManagerTelephone" required placeholder="Phone Number">
                        </div>
                        <div class="form-group">
                            <label for="ManagerName">Name</label>
                            <input type="text" class="form-control" id="ManagerName" name="ManagerName" required placeholder="Manager's Name">
                        </div>
                        <div class="form-group">
                            <label for="ManagerPassword">Password</label>
                            <input type="text" class="form-control" id="ManagerPassword" name="ManagerPassword" required placeholder="Password entry">
                        </div>
                        <button type="submit" class="btn btn-primary">Add Manager</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Edit Manager Modal -->
    <?php
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM ManagerData";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='modal fade' id='editManagerModal{$row['ManagerCode']}' tabindex='-1' role='dialog' aria-labelledby='editManagerModalLabel{$row['ManagerCode']}' aria-hidden='true'>
                    <div class='modal-dialog modal-dialog-centered' role='document'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='editManagerModalLabel{$row['ManagerCode']}'>Edit Manager Data</h5>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>
                            <div class='modal-body'>
                                <form action='edit_manager.php' method='post'>
                                    <input type='hidden' name='ManagerCode' value='{$row['ManagerCode']}'>
                                    <div class='form-group'>
                                        <label for='editManagerTelephone{$row['ManagerCode']}'>Telephone Number</label>
                                        <input type='text' class='form-control' id='editManagerTelephone{$row['ManagerCode']}' name='ManagerTelephone' value='{$row['ManagerTelephone']}' required>
                                    </div>
                                    <div class='form-group'>
                                        <label for='editManagerName{$row['ManagerCode']}'>Name</label>
                                        <input type='text' class='form-control' id='editManagerName{$row['ManagerCode']}' name='ManagerName' value='{$row['ManagerName']}' required>
                                    </div>
                                    <div class='form-group'>
                                        <label for='editManagerPassword{$row['ManagerCode']}'>Password</label>
                                        <input type='text' class='form-control' id='editManagerPassword{$row['ManagerCode']}' name='ManagerPassword' value='{$row['ManagerPassword']}' required>
                                    </div>
                                    <button type='submit' class='btn btn-primary'>Save Changes</button>
                                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>";
        }
    }

    $conn->close();
    ?>

    <!-- Delete Manager Modal -->
    <?php
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM ManagerData";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='modal fade' id='deleteManagerModal{$row['ManagerCode']}' tabindex='-1' role='dialog' aria-labelledby='deleteManagerModalLabel{$row['ManagerCode']}' aria-hidden='true'>
                    <div class='modal-dialog modal-dialog-centered' role='document'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='deleteManagerModalLabel{$row['ManagerCode']}'>Delete Manager Data</h5>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>
                            <div class='modal-body'>
                                Are you sure you want to delete Manager Code {$row['ManagerCode']}?
                            </div>
                            <div class='modal-footer'>
                                <form action='delete_manager.php' method='post'>
                                    <input type='hidden' name='ManagerCode' value='{$row['ManagerCode']}'>
                                    <button type='submit' class='btn btn-danger'>Yes, Delete</button>
                                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>No</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>";
        }
    }

    $conn->close();
    ?>

</body>
<footer>
    <p>&copy; 2023 Gately System. All rights reserved.</p>
    
</footer>
<script src="app.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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

</html>