<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CUEP | Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/welcome.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/footer.css">
    <link rel="icon" href="{{ asset('logo_cuep.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @livewireStyles
  </head>
  <body id="page-top">
    <section class="welcome max-vh-100 pb-4 mb-5" id="home">
        <nav class="navbar fixed-top navbar-expand-lg scrollspy">
            <div class="container">
                <a class="navbar-brand" href="#home">
                    <img src="/img/logo_cuep.png" alt="Bootstrap" width="150" height="80">
                </a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                  <li class="nav-item">
                    <a class="nav-link active fw-bold" aria-current="page" href="/#home">Accueil</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link fw-bold" href="#catalog">Catalogue</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link fw-bold" href="#contact">Contactez-nous</a>
                  </li>
                 @if (Auth::user())
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-connect fw-bold" href="/dashboard">Tableau de bord</a>
                    </li>
                 @else
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-connect rounded fw-bold" href="/login">Connectez-vous</a>
                    </li>
                 @endif
                </ul>
              </div>
            </div>
        </nav>
        <div class="container-fluid position-relative">

            <div class="row position-absolute top-50 w-100 d-flex align-items-center justify-content-center">
                <div class="col-11 col-lg-8 col-md-8 p-3 rounded" id="searchBar">
                    <div class="hstack gap-3">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input class="form-control me-auto border border-0" type="text" placeholder="Rechercher une ressource" autofocus>
                        <div class="vr"></div>
                        <button type="button" class="btn">Rechercher</button>
                    </div>
                </div>
            </div>

            <div id="carouselExampleFade" class="carousel slide carousel-fade mx-md-3" data-bs-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="/img/b2.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                      <h5>Notre Bibliothèque Numérique</h5>
                      <p>Une vaste collection de ressources techniques et économiques destinées aux professionnels en activité et en formation.</p>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <img src="/img/b3.png" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Explorez notre Catalogue</h5>
                        <p>Des Lives, des documents numériques et bien d'autres ressources à découvrir.</p>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <img src="/img/b4.png" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                      <h5>Réservez et Empruntez</h5>
                      <p>Connectez-vous pour réserver, emprunter ou télécharger des ressources en toute sécurité.</p>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </section>

    <section id="catalog" class="container mb-5">
        <div class="row">
            <div class="col-12">
                <h6 class="catalog-title btn">Catalogue</h6>
            </div>
            <div class="col-lg-6 col-12 mb-lg-0 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Types</h5>
                    </div>
                    <div class="card-body">
                        @if (count($types)  > 0)
                            <ul class="list-group">
                                @foreach ($types as $type)
                                    <li class="list-group-item"><i class="fa-solid fa-folder me-2"></i> <a href="/resources/types/{{ $type->id }}" class="text-decoration-none">{{ $type->name }}</a>{{ " (".count($type->resources).")" }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-danger">Aucun Type de resource enregistré pour le moment.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Catégories</h5>
                    </div>
                    <div class="card-body">
                        @if (count($categories)  > 0)
                            <div class="accordion" id="accordionExample1">
                                @foreach ($categories as $category)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id=hree{{ $category->id }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo{{ $category->id }}" aria-expanded="false" aria-controls="collapseTwo">
                                            <i class="fa-solid fa-folder me-2"></i> {{ $category->name }} {{ " (".count($category->resources).")" }}
                                        </button>
                                        </h2>
                                        <div id="collapseTwo{{ $category->id }}" class="accordion-collapse collapse" aria-labelledby="headingTwo{{ $category->id }}" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <ul class="list-group">
                                                    @foreach ($category->sub_categories as $sub_category)
                                                        @if (count($sub_category->sub_sub_categories) > 0)
                                                            <div class="accordion" id="accordionExample2">
                                                                <div class="accordion-item">
                                                                    <h2 class="accordion-header" id="headingThree{{ $sub_category->id }}">
                                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree{{ $sub_category->id }}" aria-expanded="false" aria-controls="collapseThree">
                                                                            <i class="fa-solid fa-folder me-2"></i> {{ $sub_category->name }} {{ " (".count($sub_category->resources).")" }}
                                                                        </button>
                                                                    </h2>
                                                                    <div id="collapseThree{{ $sub_category->id }}" class="accordion-collapse collapse" aria-labelledby="headingThree{{ $category->id }}" data-bs-parent="#accordionExample">
                                                                        <div class="accordion-body">
                                                                            <ul class="list-group">
                                                                                @foreach ($sub_category->sub_sub_categories as $sub_sub_category)
                                                                                    <li class="list-group-item"><i class="fa-solid fa-caret-right me-2"></i><a href="/resources/sub-categories/{{ $sub_sub_category->id }}" class="text-decoration-none">{{ $sub_sub_category->name }}</a>{{ " (".count($sub_sub_category->resources).")" }}</li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <li class="list-group-item"><i class="fa-solid fa-folder me-2"></i><a href="/resources/sub-categories/{{ $sub_category->id }}" class="text-decoration-none">{{ $sub_category->name }}</a>{{ " (".count($sub_category->resources).")" }}</li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-danger">Aucune Catégorie de ressource enregistré pour le moment.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="container mb-3" id="contact">
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

    @include('layouts.welcome.footer')

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    @livewireScripts
  </body>
  <script>
    var scrollSpy = new bootstrap.ScrollSpy(document.body, {
      target: '.scrollspy'
    });
  </script>
</html>
