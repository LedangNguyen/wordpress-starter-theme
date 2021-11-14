// Helper for Swiper slider

import { A11y } from 'swiper';

/**
 * @typedef { import('swiper').SwiperOptions } SwiperOptions
 * @typedef { import('swiper').Swiper } SwiperInstance
 */

/**
 * @param {Element} element
 * @param {SwiperOptions} options
 * @param {SwiperInstance} Swiper
 */
export const setupSwiper = (element, options = {}, Swiper) => {
  Swiper.use([A11y]);

  const slides = element.querySelectorAll('.swiper-slide');
  const newOptions = options;
  const slidesMoreThanPerView = slides.length > newOptions.slidesPerView;

  // Overwrite autoplay options
  if (newOptions.autoplay) {
    newOptions.autoplay = slidesMoreThanPerView ? newOptions.autoplay : false;
  }

  // Overwrite loop options
  if (newOptions.loop) {
    newOptions.loop = slidesMoreThanPerView ? newOptions.loop : false;
  }

  newOptions.a11y = {
    enabled: true,
  };

  // Init swiper
  const instance = new Swiper(element, newOptions);

  // Disable autoplay when swiper out of viewport
  if (newOptions.autoplay) {
    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (instance.autoplay && entry.intersectionRatio > 0) {
          instance.autoplay.start();
        } else {
          instance.autoplay.stop();
        }
      });
    });

    observer.observe(element);
  }

  return instance;
};
