<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CUEP | Lecteur</title>

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

    <link href="/css/add-reader.css" rel="stylesheet">

    <link href="/css/modal.css" rel="stylesheet">


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
                        <h1 class="h3 mb-0 text-gray-800">Ajout d'un nouvel lecteur</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="/readers">Lecteurs</a></li>
                              <li class="breadcrumb-item active" aria-current="page">{{ isset($reader) ? 'Modifier' : 'Ajouter' }} Lecteur</li>
                            </ol>
                          </nav>
                    </div>
                    <p class="mb-4">Remplissez les informations ci-dessous pour {{ isset($reader) ? 'modifier un' : 'ajouter un nouvel' }} lecteur.</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold" id="main-title">Formulaire {{ isset($reader) ? 'de modification' : 'd\'ajout' }}   de lecteur</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ isset($reader) ? '/readers/'.$reader->id : '/readers' }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if (isset($reader))
                                    @method('PUT')
                                @endif
                                <div class="row">
                                    <div class="col-lg-3 col-12 mb-lg-0 mb-3 me-md-0 me-3 py-3" id="photo-bloc">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-12 text-center mb-1">
                                                <img src="{{ (isset($reader) && $reader->photo!=null) ? '/storage/profiles/'.$reader->photo : '/img/dafault_photo.png' }}" class="img-thumbnail" alt="" id="ImagePreview">
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group">
                                                    <label class="input-group-text" for="ImageInput">Photo</label>
                                                    <input type="file" class="form-control" id="ImageInput" name="photo">
                                                </div>
                                                @error('photo')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-9 col-12">
                                        <div class="row mb-lg-3">
                                            <div class="col-lg-6 col-12 mb-lg-0 mb-3">
                                                <div class="row">
                                                    <div class="col-12 input-group">
                                                        <span class="input-group-text" id="basic-addon2">NIP<span class="text-danger fw-bold">*</span></span>
                                                        <input type="text" class="form-control" placeholder="Entrez son NIP" autofocus aria-describedby="basic-addon1" required name="npi" value="{{ isset($reader) ? $reader->npi : old('npi') }}">
                                                    </div>
                                                    @error('npi')
                                                        <div class="col-12 text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-12 mb-lg-0 mb-3">
                                                <div class="row">
                                                    <div class="col-12 input-group">
                                                        <span class="input-group-text" id="basic-addon1">Matricule<span class="text-danger fw-bold">*</span></span>
                                                        <input type="text" class="form-control" placeholder="Entrez son matricule" required name="registration_number" value="{{ isset($reader) ? $reader->registration_number : old('registration_number') }}">
                                                    </div>
                                                    @error('registration_number')
                                                        <div class="col-12 text-danger">Le champ matricule doit comporter 12 caractères.</div>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-6 col-12 mb-lg-0 mb-3">
                                                <div class="row">
                                                    <div class="col-12 input-group">
                                                        <span class="input-group-text" id="basic-addon1">Nom<span class="text-danger fw-bold">*</span></span>
                                                        <input type="text" class="form-control" placeholder="Entrez son nom" required name="lastname" value="{{ isset($reader) ? $reader->lastname : old('lastname') }}">
                                                    </div>
                                                    @error('lastname')
                                                        <div class="col-12 text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-12">
                                                <div class="row">
                                                    <div class="col-12 input-group">
                                                        <span class="input-group-text" id="basic-addon2">Prénoms<span class="text-danger fw-bold">*</span></span>
                                                        <input type="text" class="form-control" placeholder="Entrez son prénom" required name="firstname" value="{{ isset($reader) ? $reader->firstname : old('firstname') }}">
                                                    </div>
                                                    @error('firstname')
                                                        <div class="col-12 text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- <div class="col-lg-6 col-12">
                                                <div class="row">
                                                    <div class="col-12 input-group d-flex">
                                                        <label class="input-group-text" for="inputGroupSelect01">Catégorie<span class="text-danger fw-bold">*</span></label>
                                                        <select class="form-select flex-grow-1" id="inputGroupSelect01" name="role">
                                                            @if (!isset($reader))
                                                                <option value="">Choisir sa catégorie</option>
                                                            @endif
                                                                <option {{ (isset($reader) && ($reader->role == "Etudiant")) ? 'selected' : '' }} value="Etudiant">Etudiant</option>
                                                                <option {{ (isset($reader) && ($reader->role == "Professeur")) ? 'selected' : '' }} value="Professeur">Professeur</option>
                                                                <option {{ (isset($reader) && ($reader->role == "Personnel")) ? 'selected' : '' }} value="Personnel">Personnel</option>
                                                                <option {{ (isset($reader) && ($reader->role == "Autre")) ? 'selected' : '' }} value="Autre">Autre</option>
                                                        </select>
                                                    </div>
                                                    @error('role')
                                                        <div class="col-12 text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div> -->
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-lg-6 col-12 mb-lg-0 mb-3">
                                                <div class="row">
                                                    <div class="col-12 input-group">
                                                        <span class="input-group-text" id="basic-addon3">Téléphone<span class="text-danger fw-bold">*</span></span>
                                                        <input type="text" class="form-control" placeholder="Entrez son téléphone" required name="phone_number" value="{{ isset($reader) ? $reader->phone_number : old('phone_number') }}">
                                                    </div>
                                                    @error('phone_number')
                                                        <div class="col-12 text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-12 mb-lg-0 mb-3">
                                                <div class="row">
                                                    <div class="col-12 input-group">
                                                        <span class="input-group-text" id="basic-addon4">Email<span class="text-danger fw-bold">*</span></span>
                                                        <input type="text" class="form-control" placeholder="Entrez son email" name="email" value="{{ isset($reader) ? $reader->email : old('email') }}">
                                                    </div>
                                                    @error('email')
                                                        <div class="col-12 text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-12 input-group d-flex">
                                                            <label class="input-group-text" for="inputGroupSelect01">Catégorie<span class="text-danger fw-bold">*</span></label>
                                                            <select class="form-select flex-grow-1" id="inputGroupSelect01" name="role">
                                                                @if (!isset($reader))
                                                                    <option value="">Choisir sa catégorie</option>
                                                                @endif
                                                                    <option {{ (isset($reader) && ($reader->role == "Etudiant")) ? 'selected' : '' }} value="Etudiant">Etudiant</option>
                                                                    <option {{ (isset($reader) && ($reader->role == "Professeur")) ? 'selected' : '' }} value="Professeur">Professeur</option>
                                                                    <option {{ (isset($reader) && ($reader->role == "Personnel")) ? 'selected' : '' }} value="Personnel">Personnel</option>
                                                                    <option {{ (isset($reader) && ($reader->role == "Autre")) ? 'selected' : '' }} value="Autre">Autre</option>
                                                            </select>
                                                        </div>
                                                        @error('role')
                                                            <div class="col-12 text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-12 input-group">
                                                        <span class="input-group-text" id="basic-addon5">Adresse<span class="text-danger fw-bold">*</span></span>
                                                        <input type="text" class="form-control" placeholder="Entrez son adresse" required name="address" value="{{ isset($reader) ? $reader->address : old('address') }}">
                                                    </div>
                                                    @error('address')
                                                        <div class="col-12 text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn" id="submit-btn">{{ isset($reader) ? 'Modifier' : 'Ajouter' }}</button>
                                    </div>
                                </div>
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

    <script src="/js/image-preview.js"></script>

</body>

</html>
