<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ressource</title>

    <!-- Custom fonts for this template-->
    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom styles for this template-->
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">

    <link href="/css/side-bar.css" rel="stylesheet">

    <link href="/css/add-resource.css" rel="stylesheet">

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
                        <h1 class="h3 mb-0 text-gray-800">{{ isset($resource) ? 'Modification d\'une' : 'Ajout d\'une nouvel' }} ressource</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="/resources">Ressources</a></li>
                              <li class="breadcrumb-item active" aria-current="page">{{ isset($resource) ? 'Modifier' : 'Ajouter' }} Ressource</li>
                            </ol>
                          </nav>
                    </div>
                    <p class="mb-4">Remplissez les informations ci-dessous pour {{ isset($resource) ? 'modifier une' : 'ajouter une nouvelle' }} ressource.</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold" id="main-title">Formulaire {{ isset($resource) ? 'de modification' : 'd\'ajout' }} de ressource</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ isset($resource) ? '/resources/'.$resource->id : '/resources' }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if (isset($resource))
                                    @method('PUT')
                                @endif
                                <div class="row">
                                    <div class="col-lg-3 col-12 mb-lg-0 mb-3 me-md-0 me-3 py-3" id="photo-bloc">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-12 text-center mb-1">
                                                <img src="{{ (isset($resource) && $resource->cover_page!=null) ? '/storage/coverPages/'.$resource->cover_page : '/img/dafault_photo.png' }}" class="img-thumbnail" alt="" id="ImagePreview">
                                            </div>
                                            @if (Auth::user()->role === "Bibliothécaire")
                                                <div class="col-12">
                                                    <div class="input-group">
                                                        <label class="input-group-text" for="ImageInput">Photo <span class="text-danger fw-bold">*</span></label>
                                                        <input type="file" class="form-control" id="ImageInput" name="cover_page" {{ isset($resource) ? '' : ' required ' }}>
                                                    </div>
                                                    @error('photo')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-9 col-12">
                                        <div class="row">
                                            <div class="col-lg-6 col-12 mb-3">
                                                <div class="row">
                                                    <div class="col-12 input-group">
                                                        <span class="input-group-text" id="basic-addon1">ISBN</span>
                                                        <input type="number" class="form-control" placeholder="Entrez son numéro d'didentification" autofocus name="identification_number" value="{{ isset($resource) ? $resource->identification_number : old('identification_number') }}" {{ Auth::user()->role === "Bibliothécaire" ? '' : ' readonly ' }}>
                                                    </div>
                                                    @error('identification_number')
                                                        <div class="col-12 text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-12 mb-3">
                                                <div class="row">
                                                    <div class="col-12 input-group">
                                                        <span class="input-group-text" id="basic-addon1">N°<span class="text-danger fw-bold">*</span></span>
                                                        <input type="number" class="form-control" placeholder="Entrez son numéro d'enregistrement" required name="registration_number" value="{{ isset($resource) ? $resource->registration_number : old('registration_number') }}" {{ Auth::user()->role === "Bibliothécaire" ? '' : ' readonly ' }}>
                                                    </div>
                                                    @error('registration_number')
                                                        <div class="col-12 text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-12 mb-3">
                                                <div class="row">
                                                    <div class="col-12 input-group">
                                                        <span class="input-group-text" id="basic-addon1">Pages<span class="text-danger fw-bold">*</span></span>
                                                        <input type="number" class="form-control" placeholder="Entrez son nombre de page" required name="page_number" value="{{ isset($resource) ? $resource->page_number : old('page_number') }}" {{ Auth::user()->role === "Bibliothécaire" ? '' : ' readonly ' }}>
                                                    </div>
                                                    @error('page_number')
                                                        <div class="col-12 text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-12 mb-3">
                                                <div class="row">
                                                    <div class="col-12 input-group">
                                                        <span class="input-group-text" id="basic-addon1">Exemplaire<span class="text-danger fw-bold">*</span></span>
                                                        <input type="number" class="form-control" placeholder="Nombre d'exemplaire" required name="copies_number" value="{{ isset($resource) ? $resource->copies_number : old('copies_number') }}" {{ Auth::user()->role === "Bibliothécaire" ? '' : ' readonly ' }}>
                                                    </div>
                                                    @error('copies_number')
                                                        <div class="col-12 text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-12 mb-3" >
                                                <div class="row">
                                                    <div class="col-12 input-group">
                                                        <span class="input-group-text" id="basic-addon2">Titre<span class="text-danger fw-bold">*</span></span>
                                                        <input type="text" class="form-control" placeholder="Entrez son titre" required name="title" value="{{ isset($resource) ? $resource->title : old('title') }}" {{ Auth::user()->role === "Bibliothécaire" ? '' : ' readonly ' }}>
                                                    </div>
                                                    @error('title')
                                                        <div class="col-12 text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-12 mb-3">
                                                <div class="row">
                                                    <div class="col-12 input-group d-flex">
                                                        <label class="input-group-text" for="inputGroupSelect01">Type<span class="text-danger fw-bold">*</span></label>
                                                        <select class="form-select flex-grow-1 m-0" id="inputGroupSelect01" required name="type_id" {{ Auth::user()->role === "Bibliothécaire" ? '' : ' disabled ' }}>
                                                            @if (!isset($resource))
                                                                <option value="">Choisir son type</option>
                                                            @endif
                                                            @foreach ($types as $type)
                                                                <option {{ (isset($resource) && ($resource->type->id == $type->id)) ? 'selected' : '' }} value="{{ $type->id }}">{{ $type->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('type_id')
                                                        <div class="col-12 text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            @livewire('categoy-and-sub-catagory-form', ['resource' => isset($resource) ? $resource : null])

                                            <div class="col-12 mb-3">
                                                <div class="row">
                                                    <div class="col-12 input-group">
                                                        <span class="input-group-text" id="basic-addon2">Auteur(s)<span class="text-danger fw-bold">*</span></span>
                                                        <input type="text" class="form-control" placeholder="Entrez le nom complet de ses auteurs" required name="authors" value="{{ isset($resource) ? $resource->authors : old('authors') }}" {{ Auth::user()->role === "Bibliothécaire" ? '' : ' readonly ' }}>
                                                    </div>
                                                    @error('authors')
                                                        <div class="col-12 text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-12 mb-3">
                                                <div class="row">
                                                    <div class="col-12 input-group">
                                                        <label class="input-group-text" id="basic-addon2">Mots-clés<span class="text-danger fw-bold">*</span></label>
                                                        <textarea class="form-control" rows="2" placeholder="Mettez ici quelques mots clés pour faciliter la recherche de cette ressource" required name="keywords" {{ Auth::user()->role === "Bibliothécaire" ? '' : ' readonly ' }}>{{ isset($resource) ? $resource->keywords : old('keywords') }}</textarea>
                                                    </div>
                                                    @error('keywords')
                                                        <div class="col-12 text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-12 mb-3">
                                                <div class="row">
                                                    <div class="col-12 input-group">
                                                        <span class="input-group-text" id="basic-addon2">Edition</span>
                                                        <input type="text" class="form-control" placeholder="Entrez son editeur, ville et année d'édition" name="edition" value="{{ isset($resource) ? $resource->edition : old('edition') }}" {{ Auth::user()->role === "Bibliothécaire" ? '' : ' readonly ' }}>
                                                    </div>
                                                    @error('edition')
                                                        <div class="col-12 text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-12 mb-3">
                                                <div class="row">
                                                    <div class="col-12 input-group">
                                                        <span class="input-group-text" id="basic-addon2">Rayon</span>
                                                        <input type="text" class="form-control" placeholder="Entrez le rayon du document dans la bibliothèque" name="ray" value="{{ isset($resource) ? $resource->ray : old('ray') }}" {{ Auth::user()->role === "Bibliothécaire" ? '' : ' readonly ' }}>
                                                    </div>
                                                    @error('ray')
                                                        <div class="col-12 text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            @if (Auth::user()->role === "Bibliothécaire")
                                                <div class="col-12 mb-3">
                                                    <div class="row">
                                                        <div class="col-12 input-group">
                                                            <label class="input-group-text" for="inputGroupFile01">Fichier</label>
                                                            <input type="file" class="form-control" id="FileInput" name="digital_version">
                                                        </div>
                                                        @error('digital_version')
                                                            <div class="col-12 text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        @if (Auth::user()->role === "Bibliothécaire")
                                            <button type="submit" class="btn" id="submit-btn">{{ isset($resource) ? 'Modifier' : 'Ajouter' }}</button>
                                        @endif
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

    <script src="/js/add-institute.js"></script>

    <script src="/js/image-preview.js"></script>

    @livewireScripts

</body>

</html>
