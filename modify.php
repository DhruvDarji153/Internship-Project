<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jwellary_shop";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all attractions
$query = "SELECT * FROM attractions";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Attractions</title>
    <link rel="stylesheet" href="modify.css">
</head>
<body>
    <h2>Manage Attractions</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Heading</th>
                <th>Shop Now</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['heading']); ?></td>
                    <td><a href="<?php echo htmlspecialchars($row['shop_now_link']); ?>" target="_blank">Shop Now</a></td>
                    <td>
                        <img src="<?php echo htmlspecialchars($row['image_path']); ?>" width="100">
                    </td>
                    <td>
                        <a href="attraction_update.php?id=<?php echo $row['id']; ?>" class="edit-btn">Edit</a>
                        <a href="attraction_delete.php?id=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>

<?php $conn->close(); ?>
