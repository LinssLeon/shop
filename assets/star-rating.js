/*document.addEventListener('DOMContentLoaded', function () {
    console.log("Skripte werden geladen.");

    const starRatings = document.querySelectorAll('.star-rating');

    // Iteriere über alle Sternebewertungen auf der Seite
    starRatings.forEach(function (starRating) {
        const stars = starRating.querySelectorAll('.fa-star'); // Alle Sterne in der aktuellen Bewertung
        const input = document.getElementById(starRating.getAttribute('data-input-id')); // Verstecktes Input-Feld

        // Füge Event-Listener für jeden Stern hinzu
        stars.forEach(function (star, index) {
            // Färbe die Sterne auf Mouseover
            star.addEventListener('mouseover', function () {
                updateStars(stars, index + 1);
            });

            // Setze die Sterne zurück auf das aktuelle Rating bei Mouseout
            star.addEventListener('mouseout', function () {
                updateStars(stars, input.value || 0);
            });

            // Setze das Rating auf das angeklickte Niveau
            star.addEventListener('click', function () {
                input.value = index + 1; // Setze das versteckte Input-Feld auf das aktuelle Rating
                updateStars(stars, index + 1);
            });
        });
    });

    // Hilfsfunktion, um die Sterne basierend auf dem aktuellen Rating zu aktualisieren
    function updateStars(stars, rating) {
        stars.forEach(function (star, index) {
            // Färbe Sterne basierend auf dem Index und Rating
            star.classList.toggle('text-warning', index < rating); // Aktivierte Sterne
            star.classList.toggle('text-secondary', index >= rating); // Nicht-aktivierte Sterne
        });
    }
});
*/