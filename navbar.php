<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>navbar</title>
    <link rel="stylesheet" href="home.css">
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
                <li><a href="home.php">Services</a></li>
                <li class="dropdown">
                    <a href="#">Product</a>
                    <div class="dropdown-content">
                        <a href="#">Men's</a>
                        <a href="#">Women</a>
                        <a href="#">Children</a>
                    </div>
                </li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Custom Jewelry</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="cart.php">&#128722; Cart</a></li>
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