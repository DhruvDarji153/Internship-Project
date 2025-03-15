<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "jwellary_shop");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch approved testimonials
$sql = "SELECT * FROM testimonials WHERE is_approved = 1 ORDER BY created_at DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Reviews</title>
    <link rel="stylesheet" href="testimonials.css">
</head>
<body>
    <section class="testimonial-section">
        <h2>Customer Reviews</h2>
        <p>See what clients have to say</p>

        <div class="testimonial-slider">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="testimonial-item">
                    <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" class="testimonial-image">
                    <div class="testimonial-text">
                        <?php echo $row['description']; ?>
                    </div>
                    <div class="star-rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="star <?php echo ($i <= $row['rating']) ? 'filled' : ''; ?>">&#9733;</span>
                        <?php endfor; ?>
                    </div>
                    <p>- <?php echo $row['name']; ?></p>
                </div>
            <?php endwhile; ?>
        </div>

        <?php if (isset($_SESSION['user_id'])): ?>
        <form class="review-form" action="add_review.php" method="post" enctype="multipart/form-data">
            <h3>Add Your Review</h3>
            <input type="file" name="image" required>
            <textarea name="description" placeholder="Write your review..." required></textarea>
            <input type="number" name="rating" min="1" max="5" placeholder="Rating (1-5)" required>
            <button type="submit">Submit Review</button>
        </form>
        <?php else: ?>
            <p>Please <a href="login.php">login</a> to write a review.</p>
        <?php endif; ?>
    </section>
</body>
</html>

<?php $conn->close(); ?>
