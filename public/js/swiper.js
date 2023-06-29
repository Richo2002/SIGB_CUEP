const swiper = new Swiper('.mySwiper', {
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
        // Ajustements pour les écrans de grande taille
        992: {
          slidesPerView: 4, // Afficher 5 éléments à la fois
        },
        // Ajustements pour les écrans de taille moyenne
        768: {
          slidesPerView: 2, // Afficher 3 éléments à la fois
        },
        // Ajustements pour les petits écrans et mobiles
        576: {
          slidesPerView: 1, // Afficher 1 élément à la fois
        }
      }
  });
