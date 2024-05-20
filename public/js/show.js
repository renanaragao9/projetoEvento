document.addEventListener('DOMContentLoaded', function () {
    const carousel = $('#carouselExampleIndicators');

    document.getElementById('prevBtn').addEventListener('click', function () {
        carousel.carousel('prev');
    });

    document.getElementById('nextBtn').addEventListener('click', function () {
        carousel.carousel('next');
    });
});

document.getElementById('fullscreen-button').addEventListener('click', function() {
// Encontrar a imagem ativa no carrossel
const activeItem = document.querySelector('.carousel-item.active');
const zoomButton = activeItem.querySelector('.btn-zoom');

// Simular um clique no botão de zoom
zoomButton.click();
});