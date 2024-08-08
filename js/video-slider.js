jQuery(document).ready(function($) {
    var $slider = $('.video-slider');
    var $slides = $slider.children('.video-slide');
    var slideCount = $slides.length;
    var slideHeight = $slides.outerHeight(true); // Include margin in the height
    var currentIndex = 0;

    function updateSlider() {
        var offset = -currentIndex * slideHeight;
        $slider.css('transform', 'translateY(' + offset + 'px)');
    }

    $('.next-slide').on('click', function() {
        if (currentIndex < slideCount - 1) {
            currentIndex++;
            updateSlider();
        }
    });

    $('.prev-slide').on('click', function() {
        if (currentIndex > 0) {
            currentIndex--;
            updateSlider();
        }
    });

    updateSlider(); // Initialize slider position
});
