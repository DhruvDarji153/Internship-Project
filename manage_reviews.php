<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin'])) {
    echo "<script>alert('Access denied. Admins only.'); window.location.href='login.php';</script>";
    exit;
}

// Database connection
$conn = new mysqli("localhost", "root", "", "jwellary_shop");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update approval status
if (isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    $conn->query("UPDATE testimonials SET is_approved = 1 WHERE id = $id");
} elseif (isset($_GET['hide'])) {
    $id = intval($_GET['hide']);
    $conn->query("UPDATE testimonials SET is_approved = 0 WHERE id = $id");
}

// Fetch all testimonials
$result = $conn->query("SELECT * FROM testimonials ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reviews</title>
    <link rel="stylesheet" href="testimonials.css">
</head>
<body>
    <section class="manage-reviews">
        <h2>Manage Customer Reviews</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Review</th>
                <th>Rating</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['rating']; ?>/5</td>
                    <td><?php echo ($row['is_approved']) ? 'Approved' : 'Hidden'; ?></td>
                    <td>
                        <?php if ($row['is_approved']): ?>
                            <a href="?hide=<?php echo $row['id']; ?>">Hide</a>
                        <?php else: ?>
                            <a href="?approve=<?php echo $row['id']; ?>">Approve</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </section>
</body>
</html>

<?php $conn->close(); ?>
