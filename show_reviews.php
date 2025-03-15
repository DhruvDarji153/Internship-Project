<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'jwellary_shop');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch only approved reviews
$result = $conn->query("SELECT * FROM testimonials WHERE status='approved' ORDER BY created_at DESC");
$reviews = [];
while ($row = $result->fetch_assoc()) {
    $reviews[] = $row;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Reviews</title>
    <style>
        .review-container {
            width: 80%;
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background-color: #f1f1f1;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            position: relative;
            text-align: center;
            transition: all 0.5s ease-in-out;
        }

        .review {
            display: none;
            opacity: 0;
            transform: scale(0.8);
            transition: opacity 0.3s, transform 0.3s;
        }

        .review.active {
            display: block;
            opacity: 1;
            transform: scale(1);
        }

        .review img {
            border-radius: 50%;
            width: 80px;
            height: 80px;
            object-fit: cover;
            margin-bottom: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .review h4 {
            margin: 5px 0;
            color: #333;
        }

        .rating {
            margin: 5px 0;
            color: gold;
            font-size: 18px;
        }

        .description {
            font-style: italic;
            color: #666;
            margin: 10px 0;
        }

        .arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: #007bff;
            color: white;
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .arrow:hover {
            background-color: #0056b3;
        }

        .arrow-left {
            left: -30px;
        }

        .arrow-right {
            right: -30px;
        }

        @media (max-width: 600px) {
            .arrow {
                left: 5px;
                right: 5px;
            }

            .review-container {
                width: 90%;
            }

            .arrow-left, .arrow-right {
                left: 0;
                right: 0;
            }
        }
    </style>
</head>
<body>
    <div class="review-container" id="reviewContainer">
        <?php foreach ($reviews as $index => $review) { ?>
            <div class="review <?php echo $index === 0 ? 'active' : ''; ?>" id="review-<?php echo $index; ?>">
                <img src="<?php echo $review['image']; ?>" alt="Customer Image">
                <h4><?php echo $review['name']; ?></h4>
                <div class="rating"><?php echo str_repeat('★', $review['rating']) . str_repeat('☆', 5 - $review['rating']); ?></div>
                <p class="description"><?php echo $review['description']; ?></p>
            </div>
        <?php } ?>
        <div class="arrow arrow-left" onclick="prevReview()">&#9664;</div>
        <div class="arrow arrow-right" onclick="nextReview()">&#9654;</div>
    </div>

    <script>
        let currentReview = 0;
        const reviews = document.querySelectorAll('.review');

        function showReview(index) {
            reviews.forEach((review, i) => {
                review.classList.remove('active');
                if (i === index) {
                    review.classList.add('active');
                }
            });
        }

        function nextReview() {
            currentReview = (currentReview + 1) % reviews.length;
            showReview(currentReview);
        }

        function prevReview() {
            currentReview = (currentReview - 1 + reviews.length) % reviews.length;
            showReview(currentReview);
        }

        // Auto-slide every 5 seconds
        setInterval(nextReview, 5000);
    </script>
</body>
</html>
