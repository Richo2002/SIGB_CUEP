 <!-- Sidebar -->
 <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-book"></i>
        </div>
        <div class="sidebar-brand-text mx-3">CUEP</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Tableau de bord</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Gestion
    </div>

    <!-- Nav Item - Pages Collapse Menu -->

    @if (Auth::user()->role=="Administrateur")
        <li class="nav-item">
            <a class="nav-link" href="/librarians">
                <i class="fa-solid fa-users"></i>
                <span>Bibliothécaires</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/institutes">
                <i class="fa-solid fa-university"></i>
                <span>Instituts</span>
            </a>
        </li>
    @endif

    @if (Auth::user()->role=="Bibliothécaire")

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOther"
                aria-expanded="true" aria-controls="collapseOther">
                <i class="fa-solid fa-box"></i>
                <span>Classifications</span>
            </a>
            <div id="collapseOther" class="collapse" aria-labelledby="headingOther" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="/types">Types</a>
                    <a class="collapse-item" href="/categories">Domaines</a>
                    <a class="collapse-item" href="/sub-categories">Sous Domaines</a>
                    <a class="collapse-item" href="/sub-sub-categories">Sous Sous Domaines</a>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLoaner"
                aria-expanded="true" aria-controls="collapseLoaner">
                <i class="fa-solid fa-users"></i>
                <span>Prêteurs</span>
            </a>
            <div id="collapseLoaner" class="collapse" aria-labelledby="headingLoaner" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="/readers">Lecteurs</a>
                    <a class="collapse-item" href="/groups">Groupes</a>
                </div>
            </div>
        </li>
    @endif

    @if (Auth::user()->role=="Bibliothécaire" || Auth::user()->role!="Administrateur")
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCirculation"
                aria-expanded="true" aria-controls="collapseCirculation">
                <i class="fa-solid fa-arrow-right-arrow-left"></i>
                <span>Circulations</span>
            </a>
            <div id="collapseCirculation" class="collapse" aria-labelledby="headingCirculation" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="/loans">Prêts</a>
                    <a class="collapse-item" href="/reservations">Réservations</a>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/resources">
                <i class="fa-solid fa-book"></i>
                <span>Ressources</span>
            </a>
        </li>

    @endif

    @if (Auth::user()->role!="Bibliothécaire" && Auth::user()->role!="Administrateur")
        <li class="nav-item">
            <a class="nav-link" href="/groups">
                <i class="fa-solid fa-book"></i>
                <span>Groupes</span>
            </a>
        </li>
    @endif
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
