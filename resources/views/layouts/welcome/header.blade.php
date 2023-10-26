<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/#home">
            <img src="/img/logo_cuep.png" alt="Bootstrap" width="150" height="80">
        </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="/#home">Accueil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="/#catalog">Catalogue</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/#contact">Contactez-nous</a>
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
