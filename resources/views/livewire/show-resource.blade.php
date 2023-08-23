<div>
    <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '>';">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/#catalog" class="text-decoration-none">Catalogue</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="/resources/types/{{ $resource->type->id }}" class="text-decoration-none">{{ $resource->type->name }}</a></li>
            <li class="breadcrumb-item  active" aria-current="page">{{ $resource->sub_category ? $resource->sub_category->category->name : $resource->sub_sub_category->sub_category->category->name }}</li>
            <li class="breadcrumb-item active" aria-current="page">{{ $resource->sub_category ? $resource->sub_category->name : $resource->sub_sub_category->sub_category->name }}</li>
            @if ($resource->sub_sub_category)
                <li class="breadcrumb-item active" aria-current="page">{{ $resource->sub_sub_category->name }}</li>
            @endif
        </ol>
    </nav>

    <div class="row">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <div class="col-lg-3 col-12 mb-lg-0 mb-3 me-md-0 me-3 py-3" id="photo-bloc">
            <div class="row d-flex justify-content-center">
                <div class="col-12 text-center mb-1">
                    <img src="{{ '/storage/coverPages/'.$resource->cover_page }}" class="img-thumbnail" alt="" id="ImagePreview">
                </div>
                @if ($resource->digital_version != null && Auth::user())
                    <div class="col-12 text-center">
                        <form wire:submit.prevent="download('{{ $resource->digital_version }}')">
                            <button type="submit" class="btn" id="submit-btn" wire:loading.attr="disabled">
                                <span wire:loading>
                                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                </span>
                                Télécharger<i class="fa fa-download ms-1"></i>
                            </button>
                        </form>
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
                            <input type="number" class="form-control" value="{{ $resource->identification_number }}" placeholder="Néant" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-12 mb-3">
                    <div class="row">
                        <div class="col-12 input-group">
                            <span class="input-group-text" id="basic-addon1">N°</span>
                            <input type="number" class="form-control" value="{{ $resource->registration_number }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-12 mb-3">
                    <div class="row">
                        <div class="col-12 input-group">
                            <span class="input-group-text" id="basic-addon1">Pages</span>
                            <input type="number" class="form-control" value="{{ $resource->page_number }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-12 mb-3">
                    <div class="row">
                        <div class="col-12 input-group">
                            <span class="input-group-text" id="basic-addon1">Exemplaire</span>
                            <input type="number" class="form-control" value="{{ $resource->copies_number }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-3" >
                    <div class="row">
                        <div class="col-12 input-group">
                            <span class="input-group-text" id="basic-addon2">Titre</span>
                            <input type="text" class="form-control" value="{{ $resource->title }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <div class="row">
                        <div class="col-12 input-group">
                            <span class="input-group-text" id="basic-addon2">Auteur(s)</span>
                            <input type="text" class="form-control" value="{{ $resource->authors }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <div class="row">
                        <div class="col-12 input-group">
                            <span class="input-group-text" id="basic-addon2">Langue</span>
                            <input type="text" class="form-control" value="{{ $resource->language }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <div class="row">
                        <div class="col-12 input-group">
                            <label class="input-group-text" id="basic-addon2">Mots-clés</label>
                            <textarea class="form-control" rows="2" readonly>{{ $resource->keywords }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <div class="row">
                        <div class="col-12 input-group">
                            <span class="input-group-text" id="basic-addon2">Edition</span>
                            <input type="text" class="form-control" value="{{ $resource->edition }}" placeholder="Néant" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <div class="row">
                        <div class="col-12 input-group">
                            <span class="input-group-text" id="basic-addon2">Rayon</span>
                            <input type="text" class="form-control" value="{{ $resource->ray }}" placeholder="Néant" readonly>
                        </div>
                    </div>
                </div>
                @if ($resource->digital_version != null && Auth::user())
                    <div class="col-12 mb-3">
                        <div class="row">
                            <div class="col-12 input-group">
                                <span class="input-group-text" id="basic-addon2">Version digitale</span>
                                <input type="text" class="form-control" value="{{ 'Fichier '.$extension. ' de taille '. $size. 'Mo' }}" placeholder="Néant" readonly>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
