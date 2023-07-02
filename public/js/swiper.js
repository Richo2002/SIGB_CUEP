const swiper = new Swiper('.swiper', {
    direction: 'horizontal',
    spaceBetween: 30,
    loop:true,

    pagination: {
        el: ".swiper-pagination",
        type: "fraction",
      },

    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },


    breakpoints: {

        992: {
          slidesPerView: 5,
        },

        768: {
          slidesPerView: 3,
        },

        576: {
          slidesPerView: 1,
        }
      }
  });
