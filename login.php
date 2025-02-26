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
                    $_SESSION['user_role'] = $user['role'];

                    // JavaScript alert message
                    $welcome_message = "Welcome, " . $user['name'] . "!";

                    // Redirect based on user role
                    if ($user['role'] === 'admin') {
                        echo "<script>
                                alert('$welcome_message');
                                window.location.href = 'admin.php';
                              </script>";
                    } else if ($user['role'] === 'user') {
                        echo "<script>
                                alert('$welcome_message');
                                window.location.href = 'home.php';
                              </script>";
                    } else if ($user['role'] === 'manager') {
                        echo "<script>
                                alert('$welcome_message');
                                window.location.href = 'manager.php';
                              </script>";
                    } else {
                        echo "<script>
                                alert('Invalid user role. Redirecting to signup.');
                                window.location.href = 'signup.php';
                              </script>";
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
