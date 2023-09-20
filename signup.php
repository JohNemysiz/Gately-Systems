<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    integrity="sha384-ABC123XYZ" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Caprasimo&display=swap" rel="stylesheet">
  <link rel="icon" href="pics/logo.png" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="style.css">
  <!-- <link rel="stylesheet" type="text/css" href="styles.css"> -->
  <title>Sign up-Gately System</title>
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

    .form-group p {
      color: red;
    }
  </style>
</head>

<body style="background-color: #ffff;">
  <header>
    <nav>
      <div class="logo">
        <a href="index.php" style="font-family: 'Caprasimo', cursive ,sans-serif;font-size: 29px;">Gately Systems</a>
      </div>
      <ul class="nav-links">
        <li><a href="admin.php">Admin</a></li>
        <li><a href="manager.php">Manager</a></li>
        <li><a href="index.php">Home</a></li>
        <li><a href="mailto:info@gatelysystems.com">Contact</a></li>
        <li class="sign-up"><a href="signin.php">Sign In</a></li>
      </ul>
      <div class="burger">
        <div class="line1"></div>
        <div class="line2"></div>
        <div class="line3"></div>
      </div>
    </nav>
  </header>
  <div class="container">
    <form action="signingin.php" method="POST">
      <h1>Sign up</h1><br>
      <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="tel" id="phoneInput" name="phone"
          value="<?php echo isset($phone) ? htmlspecialchars($phone) : ''; ?>">
        <?php if (isset($_GET["error"]) && $_GET["error"] === "Phone number is required") {
          echo "<p>Phone number is required*.</p>";
        } ?>
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="emailInput" name="email"
          value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
        <?php if (isset($_GET["error"]) && $_GET["error"] === "Email is required") {
          echo "<p>Email is required*.</p>";
        } ?>
      </div>

      <div class="form-group">
        <label for="showPassword">Password:</label>
        <input type="password" id="passwordInput" name="password" value="">
        <input type="checkbox" id="showPassword">Show Password
        <?php
        if (isset($_GET["error"])) {
          if ($_GET["error"] === "Password is required") {
            echo "<p>Password is required*.</p>";
          } elseif ($_GET["error"] === "Password must be exactly 8 characters") {
            echo "<p>Password must be exactly 8 characters*.</p>";
          }
        }
        ?>
      </div>
      <button type="submit">Sign Up</button>
      <div class="additional-links">
        <a href="signin.php" class="left-link">I have an account</a>
      </div>
    </form>
  </div>
  <footer>
    <p>&copy; 2023 Gately System. All rights reserved.</p>
  </footer>
  <script src="app.js"></script>
</body>

</html>