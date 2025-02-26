<?php
include 'db.php'; // Database connection

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_carousel'])) {
    $heading = $_POST['heading'];
    $description = $_POST['description'];
    $highlighted_text = $_POST['highlighted_text'];
    $button_text = $_POST['button_text'];
    $button_link = $_POST['button_link'];
    
    // Handle image upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    
    // Insert into database
    $sql = "INSERT INTO carousel (image_path, heading, description, highlighted_text, button_text, button_link) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $target_file, $heading, $description, $highlighted_text, $button_text, $button_link);
    $stmt->execute();
    
    echo "Carousel item added successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Carousel Item</title>
</head>
<body>
    <h2>Add New Carousel Item</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <label>Heading:</label>
        <input type="text" name="heading" required><br>
        <label>Description:</label>
        <textarea name="description" required></textarea><br>
        <label>Highlighted Text:</label>
        <input type="text" name="highlighted_text"><br>
        <label>Button Text:</label>
        <input type="text" name="button_text"><br>
        <label>Button Link:</label>
        <input type="text" name="button_link"><br>
        <label>Image:</label>
        <input type="file" name="image" required><br>
        <button type="submit" name="add_carousel">Add Carousel Item</button>
    </form>
</body>
</html>
