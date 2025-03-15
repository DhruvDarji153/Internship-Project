<?php
session_start();
include 'db_connect.php'; 

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM products WHERE id=$id";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $jewelry_type = $_POST['jewelry_type'];
    $purity = $_POST['purity'];
    $metal = $_POST['metal'];
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    // Update query
    $updateQuery = "UPDATE products SET 
                    name='$name', description='$description', category='$category', 
                    price='$price', jewelry_type='$jewelry_type', purity='$purity', 
                    metal='$metal', is_featured='$is_featured' 
                    WHERE id=$id";

    if (mysqli_query($conn, $updateQuery)) {
        echo "Product updated successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modify Product</title>
    <link rel="stylesheet" href="modisy_product.css">
</head>
<body>
<h2>Modify Product</h2>
<form action="" method="POST">
    <input type="hidden" name="id" value="<?= $product['id'] ?>">
    Name: <input type="text" name="name" value="<?= $product['name'] ?>" required><br>
    Description: <textarea name="description"><?= $product['description'] ?></textarea><br>
    Price: <input type="number" name="price" value="<?= $product['price'] ?>" required><br>
    Category:
    <select name="category">
        <option value="Men" <?= $product['category'] == 'Men' ? 'selected' : '' ?>>Men</option>
        <option value="Women" <?= $product['category'] == 'Women' ? 'selected' : '' ?>>Women</option>
        <option value="Children" <?= $product['category'] == 'Children' ? 'selected' : '' ?>>Children</option>
    </select><br>
    Jewelry Type: <input type="text" name="jewelry_type" value="<?= $product['jewelry_type'] ?>"><br>
    Purity: <input type="text" name="purity" value="<?= $product['purity'] ?>"><br>
    Metal: <input type="text" name="metal" value="<?= $product['metal'] ?>"><br>
    Featured: <input type="checkbox" name="is_featured" <?= $product['is_featured'] ? 'checked' : '' ?>><br>
    <button type="submit">Update Product</button>
</form>
</body>
</html>
