<?php
session_start();
include 'db_connect.php'; // Database connection

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the product to delete the image from the server
    $query = "SELECT image FROM products WHERE id=$id";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result);

    if ($product) {
        // Delete image file from the server
        $imagePath = $product['image'];
        if (file_exists($imagePath)) {
            unlink($imagePath); // Remove image from the 'uploads' folder
        }

        // Delete product from database
        $deleteQuery = "DELETE FROM products WHERE id=$id";
        if (mysqli_query($conn, $deleteQuery)) {
            echo "<script>alert('Product deleted successfully!'); window.location='show_product_list.php';</script>";
        } else {
            echo "Error deleting product: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Product not found!'); window.location='show_product_list.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location='show_product_list.php';</script>";
}
?>
