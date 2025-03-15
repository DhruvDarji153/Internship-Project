<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = "";
$dbname = "jwellary_shop";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid request: ID is missing or invalid.");
}
$id = intval($_GET['id']);

// Fetch existing attraction details
$query = "SELECT * FROM attractions WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$attraction = $result->fetch_assoc();

if (!$attraction) {
    die("Attraction not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $heading = $_POST['heading'];
    $shop_now_link = $_POST['shop_now_link'];

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $newImage = basename($_FILES['image']['name']);
        $uploadPath = "uploads/" . $newImage;

        // Move new image to uploads folder
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
            // Delete old image
            if (file_exists($attraction['image_path'])) {
                unlink($attraction['image_path']);
            }
            $image_path = $uploadPath; // Update new image path
        } else {
            die("Failed to upload new image.");
        }
    } else {
        $image_path = $attraction['image_path']; // Keep old image path
    }

    // Update attraction details
    $updateQuery = "UPDATE attractions SET product_name = ?, heading = ?, shop_now_link = ?, image_path = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("ssssi", $product_name, $heading, $shop_now_link, $image_path, $id);

    if ($updateStmt->execute()) {
        header("Location: manage_attractions.php?msg=Attraction updated successfully");
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
    <title>Update Attraction</title>
    <link rel="stylesheet" href="modify.css"> <!-- Use your existing CSS -->
</head>
<body>
    <h2>Update Attraction</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="product_name">Product Name:</label>
        <input type="text" name="product_name" id="product_name" value="<?php echo htmlspecialchars($attraction['product_name']); ?>" required>

        <label for="heading">Heading:</label>
        <input type="text" name="heading" id="heading" value="<?php echo htmlspecialchars($attraction['heading']); ?>" required>

        <label for="shop_now_link">Shop Now Link:</label>
        <input type="text" name="shop_now_link" id="shop_now_link" value="<?php echo htmlspecialchars($attraction['shop_now_link']); ?>" required>

        <label for="current_image">Current Image:</label><br>
        <img src="<?php echo htmlspecialchars($attraction['image_path']); ?>" width="100"><br>

        <label for="image">Upload New Image (Optional):</label>
        <input type="file" name="image" id="image">

        <button type="submit">Update Attraction</button>
        <a href="manage_attractions.php">Cancel</a>
    </form>
</body>
</html>

<?php $conn->close(); ?>
