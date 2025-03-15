<?php
include 'db_connect.php';

// Get category from URL (default: Men)
$category = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : "Men";

// Get filter options from database
$query = "SELECT DISTINCT purity, metal FROM products WHERE category='$category'";
$filter_result = mysqli_query($conn, $query);

// Fetch products
$query = "SELECT * FROM products WHERE category='$category' LIMIT 24";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shop - <?php echo $category; ?></title>
</head>
<body>

<h2>Shop by Gender</h2>
<a href="shop.php?category=Men">Men</a> | 
<a href="shop.php?category=Women">Women</a> | 
<a href="shop.php?category=Children">Children</a>

<h2>Filters</h2>
<form method="GET">
    <input type="hidden" name="category" value="<?php echo $category; ?>">
    Purity: <select name="purity">
        <option value="">All</option>
        <?php while ($row = mysqli_fetch_assoc($filter_result)) { ?>
            <option value="<?php echo $row['purity']; ?>"><?php echo $row['purity']; ?></option>
        <?php } ?>
    </select>
    <button type="submit">Apply</button>
</form>

<h2>Products</h2>
<div>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div>
            <img src="<?php echo $row['image']; ?>" width="150" height="150">
            <h3><?php echo $row['name']; ?></h3>
            <p><?php echo $row['description']; ?></p>
            <p>Price: ₹<?php echo $row['price']; ?></p>
            <a href="product.php?id=<?php echo $row['id']; ?>">View Details</a>
        </div>
    <?php } ?>
</div>

</body>
</html>
