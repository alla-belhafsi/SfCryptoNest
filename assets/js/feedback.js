document.addEventListener("DOMContentLoaded", function() {

    // Gestion de l'évaluation par étoiles
    const stars = document.querySelectorAll(".star");
    const ratingInput = document.getElementById("feedback_rating");
    const starRating = document.getElementById("star-rating");

    stars.forEach(function(star) {
        star.addEventListener("click", function() {
            const rating = this.dataset.rating;
            if (ratingInput !== null) {
                ratingInput.value = rating;
            }
            updateStars(rating);
        });
    });

    function updateStars(rating) {
        stars.forEach(function(star) {
            if (star.dataset.rating <= rating) {
                star.classList.add("rated");
            } else {
                star.classList.remove("rated");
            }
        });
    }
});