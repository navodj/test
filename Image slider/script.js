$(document).ready(function () {
    let index = 0;
    const slides = $(".slide");
    const totalSlides = slides.length;

    function showSlide(i) {
        if (i >= totalSlides) index = 0;
        else if (i < 0) index = totalSlides - 1;
        else index = i;

        const newTransformValue = `translateX(-${index * 100}%)`;
        $(".slides").css("transform", newTransformValue);
    }

    $(".next").click(function () {
        showSlide(index + 1);
    });

    $(".prev").click(function () {
        showSlide(index - 1);
    });

    // Optionally, add auto-slide
    setInterval(function () {
        showSlide(index + 1);
    }, 5000); // Change slide every 5 seconds
});
