<?php
include 'db.php'; // Database connection

// Fetch carousel items
$sql = "SELECT * FROM carousel";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Carousel</title>
</head>
<body>
    <h2>Existing Carousel Items</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Heading</th>
            <th>Description</th>
            <th>Highlighted Text</th>
            <th>Button Text</th>
            <th>Button Link</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><img src="<?php echo $row['image_path']; ?>" width="100"></td>
            <td><?php echo $row['heading']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['highlighted_text']; ?></td>
            <td><?php echo $row['button_text']; ?></td>
            <td><a href="<?php echo $row['button_link']; ?>" target="_blank">Link</a></td>
            <td>
                <a href="update_carousel.php?id=<?php echo $row['id']; ?>">Edit</a> |
                <a href="delete_carousel.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
