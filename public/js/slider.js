// public/js/slider.js

document.addEventListener('DOMContentLoaded', function () {
    const slider = document.getElementById('slider');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    let currentIndex = 0;
    const slides = Array.from(slider.children);
    const totalSlides = slides.length;

    function updateSlider() {
        const slideWidth = slider.children[0].offsetWidth;
        slider.style.transition = 'transform 0.5s ease-in-out';
        slider.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
    }

    function cloneSlides() {
        slides.forEach(slide => {
            const clone = slide.cloneNode(true);
            slider.appendChild(clone);
        });
    }

    function resetSlider() {
        const slideWidth = slider.children[0].offsetWidth;
        slider.style.transition = 'none';
        slider.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
    }

    prevBtn.addEventListener('click', function () {
        currentIndex = (currentIndex > 0) ? currentIndex - 1 : totalSlides - 1;
        updateSlider();
    });

    nextBtn.addEventListener('click', function () {
        currentIndex = (currentIndex < totalSlides - 1) ? currentIndex + 1 : 0;
        updateSlider();
    });

    slider.addEventListener('transitionend', function () {
        if (currentIndex >= totalSlides) {
            currentIndex = 0;
            resetSlider();
        } else if (currentIndex < 0) {
            currentIndex = totalSlides - 1;
            resetSlider();
        }
    });

    window.addEventListener('resize', updateSlider);

    cloneSlides();
    updateSlider();

    // Automatisches Sliden
    setInterval(function () {
        nextBtn.click();
    }, 5000); // Alle 5 Sekunden
});