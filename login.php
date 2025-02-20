<?php
// Include database connection
include 'db.php';

// Start session
session_start();

// Initialize error message
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    if (empty($email) || empty($password)) {
        $error_message = "Please fill in all fields!";
    } else {
        // Check user in the database
        $sql = "SELECT * FROM users WHERE email = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    // Successful login
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['user_role'] = $user['role']; // Store user role

                    // Display success message
                    echo "<script>alert('Login successful! Welcome, " . $user['name'] . "');</script>";

                    // Redirect based on user role
                    if ($user['role'] === 'admin') {
                        header("Location: admin.php");
                    } else if ($user['role'] === 'user') {
                        header("Location: user.php");
                    }else if ($user['role'] === 'manager') {
                            header("Location: manager.php");
                        }else {
                        header("Location: signup.php"); // Default redirection
                    }
                    exit();
                } else {
                    $error_message = "Invalid email or password!";
                }
            } else {
                $error_message = "Invalid email or password!";
            }
            $stmt->close();
        } else {
            $error_message = "Error: Could not prepare the query. Please try again.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Jewelry Shop</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="signup-form">
        <div class="container">
            <div class="hea">
                <h2>Login</h2>
            </div>
            <?php if (!empty($error_message)) { ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php } ?>

            <form method="POST" action="login.php">
                <div class="input">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="input">
                    <label for="password">Password :</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="signup-btn">Login</button>
                <p class="redirect">Don't have an account? <a href="signup.php">Sign Up</a></p>
            </form>
        </div>
    </div>
</body>
</html>
