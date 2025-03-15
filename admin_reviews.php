<?php
// Start the session and check if the admin is logged in
session_start();


// Database connection
$conn = new mysqli('localhost', 'root', '', 'jwellary_shop');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Review Approval
if (isset($_GET['approve'])) {
    $review_id = $_GET['approve'];
    $conn->query("UPDATE testimonials SET status='approved' WHERE id=$review_id");
}

// Handle Review Disapproval
if (isset($_GET['disapprove'])) {
    $review_id = $_GET['disapprove'];
    $conn->query("UPDATE testimonials SET status='pending' WHERE id=$review_id");
}

// Handle Review Deletion
if (isset($_GET['delete'])) {
    $review_id = $_GET['delete'];
    $conn->query("DELETE FROM testimonials WHERE id=$review_id");
}

// Fetch All Reviews
$result = $conn->query("SELECT * FROM testimonials ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Customer Reviews</title>
    <style>
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        button {
            padding: 5px 10px;
            margin: 2px;
            border-radius: 5px;
            cursor: pointer;
        }

        .approve { background-color: #28a745; color: white; }
        .disapprove { background-color: #dc3545; color: white; }
        .delete { background-color: #f44336; color: white; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Admin Dashboard - Customer Reviews</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Customer Name</th>
            <th>Image</th>
            <th>Rating</th>
            <th>Description</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><img src="<?php echo $row['image']; ?>" alt="Customer Image" width="50" height="50" style="border-radius: 50%;"></td>
            <td><?php echo str_repeat('★', $row['rating']) . str_repeat('☆', 5 - $row['rating']); ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo ucfirst($row['status']); ?></td>
            <td>
                <?php if ($row['status'] == 'pending') { ?>
                    <a href="?approve=<?php echo $row['id']; ?>"><button class="approve">Approve</button></a>
                <?php } else { ?>
                    <a href="?disapprove=<?php echo $row['id']; ?>"><button class="disapprove">Disapprove</button></a>
                <?php } ?>
                <a href="?delete=<?php echo $row['id']; ?>"><button class="delete">Delete</button></a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
