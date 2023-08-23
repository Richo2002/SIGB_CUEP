<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CUEP | Sous-Sous-Domaine</title>

    <!-- Custom fonts for this template-->
    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="icon" href="{{ asset('logo_cuep.ico') }}" type="image/x-icon">

    <!-- Custom styles for this template-->
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">

    <link href="/css/side-bar.css" rel="stylesheet">

    <link href="/css/add-domain.css" rel="stylesheet">

    <link href="/css/modal.css" rel="stylesheet">

    <link href="/css/add-sub-category.css" rel="stylesheet">

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
                        <h1 class="h3 mb-0 text-gray-800">{{ isset($sub_sub_category) ? 'Modification d\'un' : 'Ajout d\'un nouvel' }} sous sous domaine</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="/sub-categories">Sous Domianes</a></li>
                              <li class="breadcrumb-item active" aria-current="page">{{ isset($sub_sub_category) ? 'Modifier' : 'Ajouter' }} sous sous Domaine</li>
                            </ol>
                          </nav>
                    </div>
                    <p class="mb-4">Remplissez les informations ci-dessous pour {{ isset($sub_sub_category) ? 'modifier' : 'ajouter' }} un nouvel sous sous domaine au domaine <b>{{ $sub_category->name }}</b></p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold" id="main-title">Formulaire {{ isset($sub_sub_category) ? 'de modification' : 'd\'ajout' }} de sous sous domaine</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ isset($sub_sub_category) ? '/sub-sub-categories/'.$sub_sub_category->id : '/sub-categories/'.$sub_category->id.'/sub-sub-categories' }}" method="POST">
                                @csrf
                                @if (isset($sub_sub_category))
                                    @method('PUT')
                                @endif
                                <div class="row mb-3">
                                    <div class="col-lg-6 col-12 mb-lg-0 mb-3">
                                        <div class="row">
                                            <div class="col-12 input-group">
                                                <span class="input-group-text" id="basic-addon1">Numéro<span class="text-danger fw-bold">*</span></span>
                                                <input type="number" class="form-control" placeholder="Entrez le numéro de correspondance" autofocus required name="classification_number" value="{{ isset($sub_sub_category) ? $sub_sub_category->classification_number : old('classification_number') }}">
                                            </div>
                                            @error('classification_number')
                                                <div class="col-12 text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-12 mb-3">
                                        <div class="row">
                                            <div class="col-12 input-group">
                                                <span class="input-group-text" id="basic-addon1">Sous Sous Domaine<span class="text-danger fw-bold">*</span></span>
                                                <input type="text" class="form-control" placeholder="Entrez un sous sous domaine d'activité de ressource"  required name="name" value="{{ isset($sub_sub_category) ? $sub_sub_category->name : old('name') }}">
                                            </div>
                                            @error('name')
                                                <div class="col-12 text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn" id="submit-btn">{{ isset($sub_sub_category) ? 'Modifier' : 'Ajouter' }}</button>
                            </form>
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

</body>

</html>
