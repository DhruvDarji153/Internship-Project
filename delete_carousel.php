<?php
include 'db.php'; // Database connection

// Get carousel ID from URL
$id = $_GET['id'];

// Fetch the existing image path
$sql = "SELECT image_path FROM carousel WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Delete the image file from the server
if (file_exists($row['image_path'])) {
    unlink($row['image_path']);
}

// Delete the carousel entry from the database
$sql = "DELETE FROM carousel WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

// Redirect back to the view page
header("Location: view_carousel.php");
exit();
?>
