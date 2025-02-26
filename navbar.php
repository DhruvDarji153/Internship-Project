
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    
    <link rel="shortcut icon" href="images/pngegg.png" type="image/x-icon">

    <link rel="stylesheet" href="navbar.css">

    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Slick Carousel CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/slick.css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/slick-theme.css"/>

    <!-- jQuery (Required for Slick) -->
    <script src="assets/js/jquery-1.11.0.min.js"></script>

    <!-- Slick Carousel JS -->
    <script src="assets/js/slick.min.js"></script>
</head>
<body>
    <!-- Navbar -->
    <header class="header">
        <nav>
            <div class="logo">
                <a href="index.html">Jewelry <span>Luxurious</span></a>
            </div>
            <input type="checkbox" id="menu-toggle">
            <label for="menu-toggle" class="menu-icon">&#9776;</label>
            <ul class="menu">
                <li><a href="home.php">Home</a></li>
                <li class="dropdown">
                    <a href="#">Product</a>
                    <div class="dropdown-content">
                        <a href="#">Gold</a>
                        <a href="#">Diamond</a>
                        <a href="#">Silver</a>
                    </div>
                </li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Custom Jewelry</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">&#128722; Cart</a></li>
                <li class="dropdown">
                    <a href="#">Profile</a>
                    <div class="dropdown-content">
                        <a href="login.php">Login</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
    </header>


</body>
</html>
