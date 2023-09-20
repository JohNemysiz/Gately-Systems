<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,500,0,0" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Caprasimo&display=swap" rel="stylesheet">
  <link rel="icon" href="pics/logo.png" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="style.css">
  <title>Gately Systems</title>
  <style>
    .features2 {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
    }

    .container2 {
      flex: 0 0 33.33%;
      max-width: 33.33%;
      padding: 10px;
      box-sizing: border-box;
      text-align: center;
    }

    .feature {
      padding: 20px;
      background-color: #f0f0f0;
      border-radius: 5px;
    }

    .btn {
      display: inline-block;
      padding: 10px 20px;
      background-color: #00bfff;
      color: #fff;
      text-decoration: none;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    /* Add a media query for mobile devices */
    @media (max-width: 768px) {
      .container2 {
        flex: 0 0 100%;
        max-width: 100%;
      }
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
        <li><a href="index.php">Home</a></li>
        <li><a href="mailto:example@example.com">Contact</a></li>
        <li class="sign-up"><a href="logout.php">Logout</a></li>
      </ul>
      <div class="burger">
        <div class="line1"></div>
        <div class="line2"></div>
        <div class="line3"></div>
      </div>
    </nav>
  </header>
  <section class="hero2">
    <h1>DASHBOARD</h1>
  </section>
  <div class="username">
  </div>
  <section class="features2">
    <div class="container2">
      <div class="feature">
        <span class="material-symbols-outlined">
          edit
        </span>
        <h3>Transactions</h3>
        <p>View your rescent transactions </p>
        <a href="client_trans.php" class="btn">View</a>
      </div>
    </div>
    <div class="container2">
      <div class="feature">
        <span class="material-symbols-outlined">
          edit
        </span>
        <h3>Balances</h3>
        <p>Verify rent and Utility balances</p>
        <a href="client_balance.php" class="btn">View</a>
      </div>
    </div>
  </section>
  <footer class="staybt">
    <p>&copy; 2023 Gately System. All rights reserved.</p>
  </footer>

  <script src="app.js"></script>
</body>

</html>