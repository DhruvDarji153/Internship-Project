<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "jwellary_shop");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $is_new = isset($_POST['is_new']) ? 1 : 0;
    
    // Image upload handling
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_path = "uploads/" . $image;
    move_uploaded_file($image_tmp, $image_path);
    
    // Insert data into database
    $sql = "INSERT INTO featured_products (name, description, price, image, image_path, is_new) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdssi", $name, $description, $price, $image, $image_path, $is_new);
    $stmt->execute();
    header("Location: show_featured.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Featured Product</title>
    <link rel="stylesheet" href="add_featured.css">
</head>
<body>
    <h2>Add Featured Product</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="name">Product Name:</label>
        <input type="text" name="name" id="name" required><br>
        
        <label for="description">Product Description:</label>
        <textarea name="description" id="description" required></textarea><br>
        
        <label for="price">Price (INR):</label>
        <input type="number" name="price" id="price" required><br>
        
        <label for="image">Product Image:</label>
        <input type="file" name="image" id="image" required><br>
        
        <label for="is_new">
            <input type="checkbox" name="is_new" id="is_new"> Mark as New
        </label><br>
        
        <button type="submit">Add Product</button>
    </form>
    <a href="show_featured.php">View Featured Products</a>
</body>
</html>
