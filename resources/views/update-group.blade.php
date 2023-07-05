<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CUEP | Group</title>

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

    <link href="/css/add-type.css" rel="stylesheet">

    <link href="/css/modal.css" rel="stylesheet">

    <link href="/css/update-type-or-category-or-group.css" rel="stylesheet">
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
                        <h1 class="h3 mb-0 text-gray-800">Modification d'un groupe</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="/groups">Groupes</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Modifier Groupe</li>
                            </ol>
                          </nav>
                    </div>
                    <p class="mb-4">Remplissez les informations ci-dessous pour modifier un groupe.</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold" id="main-title">Formulaire de modification de groupe</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ '/groups/'.$group->id }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <div class="col-lg-6 col-12 mb-lg-0 mb-3">
                                        <div class="row">
                                            <div class="col-12 input-group">
                                                <span class="input-group-text" id="basic-addon1">Groupe</span>
                                                <input type="text" class="form-control" placeholder="Entrez un type de ressource" autofocus required name="name" value="{{ isset($group) ? $group->name : old('name') }}">
                                            </div>
                                            @error('name')
                                                <div class="col-12 text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="row">
                                            <div class="col-12 input-group">
                                                <span class="input-group-text" id="basic-addon1">Responsable</span>
                                                <select class="form-select flex-grow-1" id="inputGroupSelect01" name="responsable_id">
                                                    @if (!isset($group))
                                                        <option value="">Choisir le responsable du groupe</option>
                                                    @endif
                                                    @foreach ($readers as $reader)
                                                        <option {{ (isset($group) && ($group->responsable->id == $reader->id)) ? 'selected' : '' }} value="{{ $reader->id }}">{{ $reader->lastname." ".$reader->firstname }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('responsable_id')
                                                <div class="col-12 text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn" id="submit-btn">Modifier</button>
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
