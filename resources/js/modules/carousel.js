// Import Splide styles first
import '@splidejs/splide/css';

// Import module styles (can override third-party defaults)
import '../../css/modules/_carousel.scss';

// Import Splide
import Splide from '@splidejs/splide';

document.querySelectorAll('.carousel .splide').forEach(el => {
  const carouselContainer = el.closest('.carousel');
  const isGalleryVariation = carouselContainer && carouselContainer.classList.contains('carousel--gallery');

  new Splide(el, {
    type: 'loop',
    perPage: isGalleryVariation ? 1 : 4,
    focus: isGalleryVariation ? 'center' : false,
    gap: '20px',
    arrows: isGalleryVariation,
    pagination: true,
    autoplay: true,
    interval: 3000,
    pauseOnHover: true,
    breakpoints: isGalleryVariation ? {
      991: { perPage: 2 },
      767: { perPage: 1, focus: 'center' },
    } : {
      991: { perPage: 3 },
      767: { perPage: 2 },
    },
  }).mount();
});
