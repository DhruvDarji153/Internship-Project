<?php
session_start();
include 'db_connect.php'; // Connect to database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category']; // Ensure correct category selection
    $price = $_POST['price'];
    $jewelry_type = $_POST['jewelry_type'];
    $purity = $_POST['purity'];
    $metal = $_POST['metal'];
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    // Image Upload
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    // Insert into database
    $query = "INSERT INTO products (name, description, category, price, jewelry_type, purity, metal, image, is_featured) 
              VALUES ('$name', '$description', '$category', '$price', '$jewelry_type', '$purity', '$metal', '$target', '$is_featured')";

    if (mysqli_query($conn, $query)) {
        echo "Product added successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="add_product.css">
</head>
<body>
<h2>Add Product</h2>
<form action="" method="POST" enctype="multipart/form-data">
    Name: <input type="text" name="name" required><br>
    Description: <textarea name="description"></textarea><br>
    Price: <input type="number" name="price" required><br>
    Category:
    <select name="category">
        <option value="Men">Men</option>
        <option value="Women">Women</option>
        <option value="Children">Children</option>
    </select><br>
    Jewelry Type: <input type="text" name="jewelry_type"><br>
    Purity: <input type="text" name="purity"><br>
    Metal: <input type="text" name="metal"><br>
    Image: <input type="file" name="image" required><br>
    Featured: <input type="checkbox" name="is_featured"><br>
    <button type="submit">Add Product</button>
</form>
</body>
</html>
