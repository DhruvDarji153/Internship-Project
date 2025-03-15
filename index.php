<?php include 'db_connect.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop by Gender</title>
    <link rel="stylesheet" href="shop_by_gender.css">
</head>
<body>

<section class="shop-gender">
    <div class="gender-category">
        <a href="products.php?gender=men">
            <img src="images/men.jpg" alt="Men's Collection">
            <h3>Shop for Men</h3>
        </a>
    </div>
    <div class="gender-category">
        <a href="products.php?gender=women">
            <img src="images/women.jpg" alt="Women's Collection">
            <h3>Shop for Women</h3>
        </a>
    </div>
    <div class="gender-category">
        <a href="products.php?gender=children">
            <img src="images/children.jpg" alt="Children's Collection">
            <h3>Shop for Children</h3>
        </a>
    </div>
</section>

</body>
</html>
