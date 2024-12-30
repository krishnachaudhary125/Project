<?php
include "header.php";
include "../Database/connection.php";
include "../Function/game_function.php";
?>
<div class="category-container">
    <div class="category-slider">
        <button class="arrow previous">&#9664;</button>
        <div class="slider">
            <div class="slider-track">
                <?php
                $select_category = "SELECT * from category";
                $category_select = mysqli_query($conn, $select_category);
                while ($row_data = mysqli_fetch_assoc($category_select)):
                ?>
                <a href="games.php?category_id=<?php echo $row_data['category_id']; ?>" class="category">
                    <div><?php echo $row_data['category_name']; ?></div>
                </a>
                <?php endwhile; ?>

            </div>
        </div>
        <button class="arrow next">&#9654;</button>
    </div>
</div>

<?php
games();
gamesByCategory();
cart();
?>

<script>
// Category Slider Part Start

document.addEventListener("DOMContentLoaded", () => {
    const sliderTrack = document.querySelector(".slider-track");
    const slides = Array.from(document.querySelectorAll(".category"));
    const prevButton = document.querySelector(".arrow.previous");
    const nextButton = document.querySelector(".arrow.next");

    const slideWidth = slides[0].offsetWidth;
    let currentIndex = 0;

    // Duplicate slides dynamically for seamless looping
    function cloneSlides() {
        const firstSlides = slides.slice(0, 4).map(slide => slide.cloneNode(true));
        const lastSlides = slides.slice(-4).map(slide => slide.cloneNode(true));
        firstSlides.forEach(slide => sliderTrack.appendChild(slide));
        lastSlides.forEach(slide => sliderTrack.insertBefore(slide, sliderTrack.firstChild));
    }

    cloneSlides();

    // Adjust the slider to start at the first original slide
    sliderTrack.style.transform = `translateX(-${4 * slideWidth}px)`;

    // Update slider position
    function updateSlider() {
        sliderTrack.style.transform = `translateX(-${(currentIndex + 4) * slideWidth}px)`;
    }

    function goToNextSlide() {
        currentIndex++;
        sliderTrack.style.transition = "transform 0.5s ease-in-out";
        updateSlider();

        // If at the end, jump back to the start
        if (currentIndex >= slides.length) {
            setTimeout(() => {
                sliderTrack.style.transition = "none";
                currentIndex = 0;
                updateSlider();
            }, 500);
        }
    }

    function goToPrevSlide() {
        currentIndex--;
        sliderTrack.style.transition = "transform 0.5s ease-in-out";
        updateSlider();

        // If at the beginning, jump to the end
        if (currentIndex < 0) {
            setTimeout(() => {
                sliderTrack.style.transition = "none";
                currentIndex = slides.length - 1;
                updateSlider();
            }, 500);
        }
    }

    nextButton.addEventListener("click", goToNextSlide);
    prevButton.addEventListener("click", goToPrevSlide);
});

// Category Slider Part End


// Game Part Start

const mediaContainers = document.querySelectorAll('.game-container');

mediaContainers.forEach((container) => {
    const video = container.querySelector('.video');

    container.addEventListener('mouseover', () => {
        video.play();
    });

    container.addEventListener('mouseleave', () => {
        video.pause();
        video.currentTime = 0;
    });
});

// Game Part End
</script>

<?php
include "footer.php";
?>