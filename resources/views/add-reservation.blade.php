<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Reservation</title>

    <!-- Custom fonts for this template-->
    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom styles for this template-->
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">

    <link href="/css/side-bar.css" rel="stylesheet">

    <link href="/css/add-loan.css" rel="stylesheet">

    <link href="/css/modal.css" rel="stylesheet">

    <link href="/css/add-reservation.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('layouts.side-bar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                @include('layouts.top-bar')

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-2">
                        <h1 class="h3 mb-0 text-gray-800">Nouvelle réservation</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="/resources">Ressources</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Faire Réservations</li>
                            </ol>
                          </nav>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold" id="main-title">Formulaire d'enregistrement de réservation</h6>
                        </div>
                        <div class="card-body">
                            <p>Cher lecteur, Vous êtes sur le point de réserver les ressources suivantes : </p>

                            <ul>
                                @foreach ($resources as $resource)
                                    <li>{{ $resource->type->name." : ".$resource->title }}</li>
                                @endforeach
                            </ul>

                            <p>Veuillez noter que cette réservation sera valable à partir du {{ $start_date->format('d-m-Y') }} au {{ $end_date->format('d-m-Y') }}. Passé ce délai, si vous ne vous présentez pas à la bibliothèque pour honorer la réservation, celle-ci sera automatiquement annulée.</p>

                            <p>Si vous êtes d'accord avec ces conditions, veuillez cliquer sur le bouton ci dessous pour procéder à la réservation.</p>

                            <form action="/reservations" method="POST" class="mb-3">
                                @csrf
                                <input type="submit" class="btn" id="submit-btn" value="Enregistrer">
                            </form>

                            <p>
                                Nous vous remercions pour votre compréhension et nous sommes impatients de vous accueillir prochainement.
                            </p>
                        </div>
                    <div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="/js/demo/chart-area-demo.js"></script>
    <script src="/js/demo/chart-pie-demo.js"></script>

    <script src="/js/add-institute.js"></script>

</body>

</html>
