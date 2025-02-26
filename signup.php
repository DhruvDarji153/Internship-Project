<?php
// Include database connection
include 'db.php';

// Initialize error messages
$error_message = "";
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and sanitize input data
    $name = htmlspecialchars(trim($_POST['name']));
    $number = htmlspecialchars(trim($_POST['number']));
    $email = htmlspecialchars(trim($_POST['email']));
    $gender = htmlspecialchars(trim($_POST['gender']));
    $password = htmlspecialchars(trim($_POST['password']));
    $confirm_password = htmlspecialchars(trim($_POST['confirm_password']));

    // Check if passwords match
    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match!";
    } elseif (strlen($password) < 6) {
        $error_message = "Password must be at least 6 characters long!";
    } else {
        // Hash password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL to insert user data
        $sql = "INSERT INTO users (name, number, email, gender, password) VALUES (?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind parameters
            $stmt->bind_param("sssss", $name, $number, $email, $gender, $hashed_password);

            // Execute query
            if ($stmt->execute()) {
                // Prepare email content
                $subject = "Welcome to Jewelry Luxurious - Your Account Details";
                $message = "Dear $name,\n\nThank you for signing up at Jewelry Luxurious. Below are your account details:\n\n";
                $message .= "Email: $email\n";
                $message .= "Password: $password\n\n"; // If hashed, consider not displaying it for security.
                $message .= "Please keep this email for your records.\n\nThank you,\nJewelry Luxurious Team";

                $headers = "From: dhruvdarji1503@gmail.com";

                // Send email
                if (mail($email, $subject, $message, $headers)) {
                    $success_message = "Signup successful! An email has been sent to your registered address. You can now <a href='login.php'>Login</a>.";
                } else {
                    $error_message = "Signup successful, but we couldn't send the confirmation email.";
                }
            } else {
                $error_message = "Error: Could not execute the query. Please try again.";
            }

            // Close statement
            $stmt->close();
        } else {
            $error_message = "Error: Could not prepare the query. Please try again.";
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup | Jewelry Shop</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function validateSignupForm() {
            // Get form values
            const name = document.getElementById("full_name").value.trim();
            const number = document.getElementById("number").value.trim();
            const email = document.getElementById("email").value.trim();
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirm-password").value;
            const genderRadios = document.getElementsByName("gender");

            // Validate full name
            if (name === "") {
                alert("Please enter your full name.");
                return false;
            }

            // Validate phone number
            const phoneRegex = /^[0-9]{10}$/;
            if (!phoneRegex.test(number)) {
                alert("Please enter a valid 10-digit phone number.");
                return false;
            }

            // Validate email format
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert("Please enter a valid email address.");
                return false;
            }

            // Check if a gender is selected
            let genderSelected = false;
            for (const radio of genderRadios) {
                if (radio.checked) {
                    genderSelected = true;
                    break;
                }
            }
            if (!genderSelected) {
                alert("Please select your gender.");
                return false;
            }

            // Validate password length (minimum 6 characters)
            if (password.length < 6) {
                alert("Password must be at least 6 characters long.");
                return false;
            }

            // Check if passwords match
            if (password !== confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }

            // If all validations pass
            return true;
        }
    </script>
</head>
<body>
    <!-- Navbar -->
    <header class="header">
        <nav>
            <div class="logo">
                <a href="index.html">Jewelry <span>Luxarious</span></a>
            </div>
            <input type="checkbox" id="menu-toggle">
            <label for="menu-toggle" class="menu-icon">&#9776;</label>
            <ul class="menu">
                <li><a href="Home.php">Home</a></li>
                <li><a href="#">Product</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Custom Jewelry</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">&#128722; Cart</a></li>
                <li><a href="#">Account</a></li>
            </ul>
        </nav>
    </header>

    <!-- Signup Form -->
    <div class="signup-form">
        <div class="container">
            <div class="hea">
                <h2>Create an Account</h2>
            </div>
            <?php if (!empty($error_message)) { ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php } ?>

            <?php if (!empty($success_message)) { ?>
                <p class="success-message"><?php echo $success_message; ?></p>
            <?php } ?>

            <form method="POST" action="signup.php" onsubmit="return validateSignupForm()">
                <div class="input">
                    <label for="name">Full Name :</label>
                    <input type="text" id="full_name" name="name" placeholder="Enter your full name" >
                </div>
                <div class="input">
                    <label for="number">Phone Number :</label>
                    <input type="text" id="number" name="number" placeholder="Enter your phone number" >
                </div>
                <div class="input">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" >
                </div>
                <div class="input gender-group">
                    <label for="gender">Gender :</label>
                    <div class="radio-options">
                        <label for="male">Male</label>
                        <input type="radio" name="gender" id="male" value="Male" >
                        <label for="female">Female</label>
                        <input type="radio" name="gender" id="female" value="Female">
                        <label for="other">Other</label>
                        <input type="radio" name="gender" id="other" value="Other">
                    </div>
                </div>
                <div class="input">
                    <label for="password">Password :</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" >
                </div>
                <div class="input">
                    <label for="confirm-password">Confirm Password :</label>
                    <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirm your password" >
                </div>
                <button type="submit" class="signup-btn">Sign Up</button>
                <p class="redirect">Already have an account? <a href="login.php">Login</a></p>
            </form>
        </div>
    </div>
</body>
</html>
