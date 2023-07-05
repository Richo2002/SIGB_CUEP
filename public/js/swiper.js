var initialSwiperOptions = {
    direction: 'horizontal',
    spaceBetween: 30,
    loop: false,
    pagination: {
      el: ".swiper-pagination",
      type: "fraction",
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    breakpoints: {
      576: {
        slidesPerView: 1,
      },
      768: {
        slidesPerView: 3,
      },
      992: {
        slidesPerView: 6,
      },
    }
  };

var swiper = new Swiper('.swiper', initialSwiperOptions);

function reapplySwiperOptions() {
    swiper.params = initialSwiperOptions;
}

window.addEventListener('contentChanged', function(event) {
    var swiper = new Swiper('.swiper', initialSwiperOptions);
  });
