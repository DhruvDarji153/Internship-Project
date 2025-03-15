<?php
session_start();
include 'db_connect.php';

$result = mysqli_query($conn, "SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
</head>
<body>

<h2>Manage Products</h2>
<table border="1">
    <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Price</th>
        <th>Category</th>
        <th>Action</th>
    </tr>

    <?php while ($product = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><img src="../uploads/<?php echo $product['image']; ?>" width="50"></td>
        <td><?php echo $product['name']; ?></td>
        <td>₹<?php echo $product['price']; ?></td>
        <td><?php echo $product['category']; ?></td>
        <td>
            <a href="edit_product.php?id=<?php echo $product['id']; ?>">Edit</a>
            <a href="delete_product.php?id=<?php echo $product['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
