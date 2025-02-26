<?php
include 'db.php'; // Database connection

// Get carousel ID from URL
$id = $_GET['id'];

// Fetch existing carousel data
$sql = "SELECT * FROM carousel WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Handle form submission for update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $heading = $_POST['heading'];
    $description = $_POST['description'];
    $highlighted_text = $_POST['highlighted_text'];
    $button_text = $_POST['button_text'];
    $button_link = $_POST['button_link'];
    
    // Handle image update
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $sql = "UPDATE carousel SET image_path=?, heading=?, description=?, highlighted_text=?, button_text=?, button_link=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $target_file, $heading, $description, $highlighted_text, $button_text, $button_link, $id);
    } else {
        $sql = "UPDATE carousel SET heading=?, description=?, highlighted_text=?, button_text=?, button_link=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $heading, $description, $highlighted_text, $button_text, $button_link, $id);
    }
    $stmt->execute();
    echo "Carousel item updated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Carousel</title>
</head>
<body>
    <h2>Update Carousel Item</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <label>Heading:</label>
        <input type="text" name="heading" value="<?php echo $row['heading']; ?>" required><br>
        <label>Description:</label>
        <textarea name="description" required><?php echo $row['description']; ?></textarea><br>
        <label>Highlighted Text:</label>
        <input type="text" name="highlighted_text" value="<?php echo $row['highlighted_text']; ?>"><br>
        <label>Button Text:</label>
        <input type="text" name="button_text" value="<?php echo $row['button_text']; ?>"><br>
        <label>Button Link:</label>
        <input type="text" name="button_link" value="<?php echo $row['button_link']; ?>"><br>
        <label>Current Image:</label><br>
        <img src="<?php echo $row['image_path']; ?>" width="100"><br>
        <label>Upload New Image:</label>
        <input type="file" name="image"><br>
        <button type="submit">Update Carousel Item</button>
    </form>
</body>
</html>
