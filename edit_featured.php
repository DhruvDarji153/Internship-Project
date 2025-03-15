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

// Fetch existing product details
$query = "SELECT * FROM featured_products WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Product not found");
}

// Handle form submission for update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $is_new = isset($_POST['is_new']) ? 1 : 0;

    // Check if a new image is uploaded
    if (!empty($_FILES['image']['name'])) {
        $image = basename($_FILES['image']['name']);
        $image_path = "uploads/" . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
    } else {
        $image_path = $product['image_path']; // Keep old image
    }

    // Update product details
    $updateQuery = "UPDATE featured_products SET name = ?, description = ?, price = ?, is_new = ?, image_path = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("ssdisi", $name, $description, $price, $is_new, $image_path, $id);

    if ($updateStmt->execute()) {
        header("Location: show_featured.php");
        exit();
    } else {
        echo "Error updating record.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Featured Product</title>
    <link rel="stylesheet" href="style.css"> <!-- External CSS -->
</head>
<body>

<h2>Edit Featured Product</h2>

<form action="" method="post" enctype="multipart/form-data">
    <label for="name">Product Name:</label>
    <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>

    <label for="description">Product Description:</label>
    <textarea name="description" id="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>

    <label for="price">Price (INR):</label>
    <input type="number" name="price" id="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>

    <label for="is_new">Mark as New:</label>
    <input type="checkbox" name="is_new" id="is_new" <?php echo ($product['is_new'] ? "checked" : ""); ?>>

    <label>Current Image:</label><br>
    <img src="<?php echo htmlspecialchars($product['image_path']); ?>" width="150"><br>

    <label for="image">Upload New Image (Optional):</label>
    <input type="file" name="image" id="image">

    <button type="submit">Update Product</button>
    <a href="show_featured.php">Cancel</a>
</form>

</body>
</html>

<?php $conn->close(); ?>
