<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default is empty for XAMPP
$dbname = "jwellary_shop";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['product_name'];
    $heading = $_POST['heading'];
    $shop_now_link = $_POST['shop_now_link'];

    // Check if an image is uploaded
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/"; // Folder where images will be stored
        $image_name = basename($_FILES['image']['name']); // Get image name
        $target_file = $target_dir . $image_name; // Full path

        // Move uploaded file to 'uploads/' folder
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Insert data into the database
            $query = "INSERT INTO attractions (image, product_name, heading, shop_now_link, image_path) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssss", $image_name, $product_name, $heading, $shop_now_link, $target_file);

            if ($stmt->execute()) {
                echo "New attraction added successfully!";
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Please select an image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Attraction</title>
    <link rel="stylesheet" href="add_attraction.css"> <!-- Link to CSS file -->
</head>
<body>
    <h2>Add New Attraction</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="product_name">Product Name:</label>
        <input type="text" name="product_name" id="product_name" required>

        <label for="heading">Heading:</label>
        <input type="text" name="heading" id="heading" required>

        <label for="shop_now_link">Shop Now Link:</label>
        <input type="text" name="shop_now_link" id="shop_now_link" required>

        <label for="image">Upload Image:</label>
        <input type="file" name="image" id="image" required>

        <button type="submit">Add Attraction</button>
        <a href="admin.php">Back to Manage</a>
    </form>
</body>
</html>

<?php $conn->close(); ?>
