<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manager-Gately</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Caprasimo&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-ABC123XYZ" crossorigin="anonymous">
  <link rel="icon" href="pics/logo.png" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="styles.css">
  <link rel="stylesheet" type="text/css" href="style.css">
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

    button[type="submit"] {
      width: 100%;
    }

    .styled-input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 12px;

    }

    #telephone {
      width: 95%;
    }
  </style>
</head>

<body>
  <header>
    <nav>
      <div class="logo">
        <a href="index.php" style="font-family: 'Caprasimo', cursive ,sans-serif;font-size: 29px;">Gately Systems</a>
      </div>
      <ul class="nav-links">
        <!-- <li><a href="signin2.html">Admin</a></li> -->
        <li><a href="index.php">Home</a></li>
        <li><a href="admin.php">Admin</a></li>
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
    <form action="login.php" method="post" class="mt-3">
      <h1>Manager Login</h1><br>
      <?php if (isset($_GET['error'])) { ?>
        <p class="error">
          <?php echo $_GET['error']; ?>
        </p>
      <?php } ?>
      <div class="form-group">
        <label for="telephone">Manager Telephone:</label>
        <input type="text" id="telephone" name="telephone" class="styled-input form-control" required>
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
  <script src="script.js"></script>
</body>

</html>