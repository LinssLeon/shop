/*document.addEventListener('DOMContentLoaded', function () {
    console.log("Skripte werden geladen.");

    const starRatings = document.querySelectorAll('.star-rating');

    starRatings.forEach(function (starRating) {
        const stars = starRating.querySelectorAll('.fa-star');
        const input = document.getElementById(starRating.getAttribute('data-input-id'));

        stars.forEach(function (star, index) {
            star.addEventListener('mouseover', function () {
                updateStars(stars, index + 1);
            });

            star.addEventListener('mouseout', function () {
                updateStars(stars, input.value || 0);
            });

            star.addEventListener('click', function () {
                input.value = index + 1;
                updateStars(stars, index + 1);
            });
        });
    });

    function updateStars(stars, rating) {
        stars.forEach(function (star, index) {
            star.classList.toggle('text-warning', index < rating);
            star.classList.toggle('text-secondary', index >= rating);
        });
    }
});
*/