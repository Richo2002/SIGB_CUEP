<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CUEP | Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/welcome.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"/>
    <link rel="icon" href="{{ asset('logo_cuep.ico') }}" type="image/x-icon">
    @livewireStyles
  </head>
  <body id="page-top">
    <section class="welcome max-vh-100 pb-4 mb-5" id="home">
        <nav class="navbar fixed-top navbar-expand-lg scrollspy">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="/img/logo_cuep.png" alt="Bootstrap" width="150" height="80">
                </a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#home">Accueil</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#catalog">Catalogue</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#contact">Contactez-nous</a>
                  </li>
                 @if (Auth::user())
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-connect" href="/dashboard">Dashboard</a>
                    </li>
                 @else
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-connect rounded" href="/login">Connectez-vous</a>
                    </li>
                 @endif
                </ul>
              </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div id="carouselExampleCaptions" class="carousel slide mx-md-3" data-bs-ride="carousel">
                <div class="carousel-indicators">
                  <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                  <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                  <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                  <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>

                </div>
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="/img/b2.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                      <h5>Notre Bibliothèque Numérique</h5>
                      <p>Une vaste collection de ressources provenant de nos instituts</p>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <img src="/img/b3.png" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                      <h5>Réservez et Empruntez</h5>
                      <p>Connectez-vous pour réserver, emprunter ou télécharger des ressources en toute sécurité.</p>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <img src="/img/b4.png" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Notre Bibliothèque Numérique</h5>
                        <p>Une vaste collection de ressources provenant de nos instituts</p>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <img src="/img/b2.png" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                      <h5>Réservez et Empruntez</h5>
                      <p>Connectez-vous pour réserver, emprunter ou télécharger des ressources en toute sécurité.</p>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </section>

    @livewire('catalogue')

    <!-- Contact Form Section -->
    <section class="container mb-5 py-2" id="contact">
        <div class="row row-cols-lg-2 row-cols-1">
            <div class="col">
                <div class="row d-flex flex-column align-items-center">
                    <div class="col-12">
                        <h6 class="contact-title btn">Contactez-nous</h6>
                        <p>
                            Merci de nous contacter en écrivant à cette adresse email : <br>
                            <a href="mailto:mesrs.cuepinfos@gouv.bj" class="text-decoration-none">mesrs.cuepinfos@gouv.bj</a> Nous mettons tout en œuvre pour vous répondre le plus rapidement possible.
                            <b>Tel: (00229) 59 11 30 37</b>
                        </p>
                        <p>Horaire d'ouverture: <br>
                            Lundi-Vendredi: 8H-17H30</p>
                    </div>
                </div>
            </div>
            <div class="col">
                @livewire('contact-us')
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="container-fluid text-center py-3">
        <p class="mb-0">© 2023 CUEP. Tous droits réservés.</p>
    </footer>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="/js/swiper.js"></script>
    @livewireScripts
  </body>
  <script>
    var scrollSpy = new bootstrap.ScrollSpy(document.body, {
      target: '.scrollspy'
    });
  </script>
</html>
