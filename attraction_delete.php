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

// Fetch the image path to delete the file
$query = "SELECT image_path FROM attractions WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$attraction = $result->fetch_assoc();

if (!$attraction) {
    die("Attraction not found.");
}

// Delete the image from the server if it exists
$imagePath = $attraction['image_path'];
if (file_exists($imagePath)) {
    unlink($imagePath); // Delete the image file
}

// Delete attraction from the database
$deleteQuery = "DELETE FROM attractions WHERE id = ?";
$deleteStmt = $conn->prepare($deleteQuery);
$deleteStmt->bind_param("i", $id);

if ($deleteStmt->execute()) {
    header("Location: manage_attractions.php?msg=Attraction deleted successfully");
    exit();
} else {
    echo "Error deleting record.";
}

$conn->close();
?>
