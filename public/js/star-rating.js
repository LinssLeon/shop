// public/js/star-rating.js
document.addEventListener('DOMContentLoaded', function () {
    const starRatings = document.querySelectorAll('.star-rating');

    starRatings.forEach(starRating => {
        const inputId = starRating.getAttribute('data-input-id');
        const input = document.getElementById(inputId);
        if (!input) {
            console.error(`Input element with id ${inputId} not found.`);
            return;
        }
        const stars = starRating.querySelectorAll('.fa-star');

        stars.forEach(star => {
            star.addEventListener('mouseover', function () {
                const rating = this.getAttribute('data-rating');
                highlightStars(starRating, rating);
            });

            star.addEventListener('mouseout', function () {
                const rating = input.value;
                highlightStars(starRating, rating);
            });

            star.addEventListener('click', function () {
                const rating = this.getAttribute('data-rating');
                input.value = rating;
                highlightStars(starRating, rating);
            });
        });
    });

    function highlightStars(starRating, rating) {
        const stars = starRating.querySelectorAll('.fa-star');
        stars.forEach(star => {
            if (star.getAttribute('data-rating') <= rating) {
                star.classList.add('text-warning');
                star.classList.remove('text-secondary');
            } else {
                star.classList.add('text-secondary');
                star.classList.remove('text-warning');
            }
        });
    }
});