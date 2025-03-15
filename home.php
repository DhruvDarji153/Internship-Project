<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="home.css">

    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- jQuery (Required for Slick) -->
    <script src="assets/js/jquery-1.11.0.min.js"></script>

</head>
<body>
    <!-- Navbar -->
    <?php
      include('navbar.php')
    ?>

   <!-- Carousel Section -->
    <?php  
      include('carousel.php')
    ?>

   

    <!-- New Attraction Section -->
   <?php 
       include('attractions.php')
   ?>
   
     <!-- Best Seller Products -->
     <?php include 'video_section.php'; ?>
     
   <!-- Featured Section -->
    <?php
      include('show_featured.php')
    ?>
    <!-- Gender -->
   <?php
    include('homes.php')
   ?>
   
  
    <!-- Latest Blogs -->
    <!-- Testimonials -->
     <?php
     include('show_reviews.php');
     ?>
      <!-- Services Section -->
      <?php
      include('service.php')
      ?>
     <!-- Footer -->
    
</body>
</html>
