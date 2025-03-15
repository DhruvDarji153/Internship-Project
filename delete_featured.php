<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "jwellary_shop");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate and get product ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid request: Product ID is missing or invalid");
}
$id = intval($_GET['id']);

// Fetch the product to get the image path
$query = "SELECT image_path FROM featured_products WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Product not found");
}

// Delete the product
$deleteQuery = "DELETE FROM featured_products WHERE id = ?";
$deleteStmt = $conn->prepare($deleteQuery);
$deleteStmt->bind_param("i", $id);

if ($deleteStmt->execute()) {
    // Remove the image file from the uploads folder
    if (!empty($product['image_path']) && file_exists($product['image_path'])) {
        unlink($product['image_path']);
    }

    header("Location: show_featured.php"); // Redirect to the product listing page
    exit();
} else {
    echo "Error deleting product.";
}

$conn->close();
?>
