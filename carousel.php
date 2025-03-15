<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>carousel</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
     <!-- Carousel Section -->
 <div class="container" data-autoplay="true">
        <div class="slide">
            <img src="images/1.png" alt="Jewelry Banner">
            <div class="slider_content">
                                <p>exclusive offer -20% off this week</p>
                                <h1>Necklace</h1>
                                <span>22 Carat gold necklace for wedding</span>
                                <p class="slider_price">starting at <span>Rs. 75,999</span></p>
                                <a href="#" class="button">Shop Now</a>
                            </div>
        </div>
        <div class="slide">
            <img src="images/3 (2).jpg" alt="Jewelry Banner">
            <div class="slider_content">
                                <p>exclusive offer -40% off this week</p>
                                <h1>Earings and Pendant</h1>
                                <span>Complete bridal set with white pearls</span>
                                <p class="slider_price">starting at <span>Rs. 89,499</span></p>
                                <a href="#" class="button">Shop Now</a>
                            </div>
        </div>
        <div class="slide">
            <img src="images/2 (3).jpg" alt="Jewelry Banner">
            <div class="slider_content">
                                <p>exclusive offer -10% off this week</p>
                                <h1>Wedding Rings</h1>
                                <span>Ashirwaad Special wedding rings for couples.</span>
                                <p class="slider_price">starting at <span>Rs. 14,999</span></p>
                                <a href="#" class="button">Shop Now</a>
                            </div>
        </div>

        <button class="prev" onclick="prevSlide()"><i class="fa fa-angle-left"></i></button>
        <button class="next" onclick="nextSlide()"><i class="fa fa-angle-right"></i></button>
    </div>
    <div class="dots_container" id="indicator"></div>
    <script>                                                                                                                                                             
        var slides = document.getElementsByClassName("slide");
        var dotsContainer = document.getElementById("indicator");
        var dots = [];
        var count = 0;
        var interval = 3500;
        var autoplay = document.querySelector(".container").getAttribute("data-autoplay");

        window.onload = function () {
            initializeSlider();
            slides[0].style.opacity = "1";
            for (var i = 0; i < slides.length; i++) {
                var dot = document.createElement("div");
                dot.classList.add("dots");
                dot.setAttribute("onclick", "changeSlide(" + i + ")");
                dotsContainer.appendChild(dot);
                dots.push(dot);
            }
            dots[0].classList.add("active");
        }

        function initializeSlider() {
            if (autoplay === "true") {
                setInterval(nextSlide, interval);
            }
        }

        function changeSlide(index) {
            count = index;
            updateSlides();
        }

        function nextSlide() {
            count = (count + 1) % slides.length;
            updateSlides();
        }

        function prevSlide() {
            count = (count - 1 + slides.length) % slides.length;
            updateSlides();
        }

        function updateSlides() {
            for (var i = 0; i < slides.length; i++) {
                slides[i].style.opacity = "0";
                dots[i].classList.remove("active");
            }
            slides[count].style.opacity = "1";
            dots[count].classList.add("active");
        }
    </script>
</body>
</html>