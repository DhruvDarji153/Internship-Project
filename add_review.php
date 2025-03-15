<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Reviews</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2, p {
            text-align: center;
            margin: 10px 0;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }

        input, textarea, select {
            width: 100%;
            padding: 8px;
            margin: 6px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .success {
            color: green;
            text-align: center;
        }

        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Customer Reviews</h2>
        <p>What our customers say</p>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Database connection
            $conn = new mysqli('localhost', 'root', '', 'jwellary_shop');

            if ($conn->connect_error) {
                die("<p class='error'>Connection failed: " . $conn->connect_error . "</p>");
            }

            // Get form data
            $name = $_POST['name'];
            $description = $_POST['description'];
            $rating = $_POST['rating'];

            // Handle image upload
            $target_dir = "uploads/";
            $image_name = basename($_FILES["image"]["name"]);
            $target_file = $target_dir . uniqid() . "_" . $image_name;

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Insert into database
                $sql = "INSERT INTO testimonials (user_id, name, image, description, rating) 
                        VALUES (1, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssi", $name, $target_file, $description, $rating);

                if ($stmt->execute()) {
                    echo "<p class='success'>Review submitted successfully!</p>";
                } else {
                    echo "<p class='error'>Error: " . $stmt->error . "</p>";
                }

                $stmt->close();
            } else {
                echo "<p class='error'>Error uploading image.</p>";
            }

            $conn->close();
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Your Name" required>

            <label for="image">Upload Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" placeholder="Write your review..." required></textarea>

            <label for="rating">Rating (1 to 5):</label>
            <select id="rating" name="rating" required>
                <option value="5">★★★★★ - Excellent</option>
                <option value="4">★★★★☆ - Good</option>
                <option value="3">★★★☆☆ - Average</option>
                <option value="2">★★☆☆☆ - Poor</option>
                <option value="1">★☆☆☆☆ - Very Poor</option>
            </select>

            <button type="submit">Submit Review</button>
        </form>
    </div>
</body>
</html>
