<div>
    <section id="catalog" class="container mb-5">
        <div class="row">
            <div class="col-12">
                <div class="row">
                  <div class="col">
                    <h6 class="catalog-title btn">Catalogue</h6>
                  </div>
                  <div class="col-12">
                    <div class="row row-cols-lg-2 row-cols-1">
                        <div class="col mb-3">
                            <select class="form-select" id="filter-type" wire:model="typeSelect" wire:change="sortOrSearchResource">
                              <option value="" >Tous les types</option>
                              @foreach ($types as $type)
                                  <option value="{{ $type->id }}">{{ $type->name }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="col-12">
                            <select class="form-select" id="filter-domain" wire:model="categorySelect" wire:change="sortOrSearchResource">
                              <option value="">Tous les domaines</option>
                              @foreach ($categories as $category)
                                  <option value="{{ $category->id }}">{{ $category->name }}</option>
                              @endforeach
                            </select>
                          </div>
                    </div>
                    <div class="row row-cols-lg-2 row-cols-1">
                        <div class="col mb-3">
                            <select class="form-select" id="filter-domain" wire:model="subCategorySelect" wire:change="sortOrSearchResource">
                              <option value="">Tous les sous domaines</option>
                              @foreach ($subCategories as $subCategory)
                                  <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="col mb-3">
                            <input type="text" class="form-control" id="filter-author" placeholder="Rechercher" wire:model.debounce.150ms="searchInput">
                          </div>
                        </div>
                    </div>
                  </div>
            </div>
            <div class="col-12">
                @if (count($resources) > 0)
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            @foreach ($resources as $resource)
                                <div class="swiper-slide" wire:click.prevent="showDetails({{ $resource->id }})" data-bs-toggle="modal" data-bs-target="#staticBackdrop" wire:key="{{ $resource->id }}">
                                    <a href="">
                                        <img src="{{ '/storage/coverPages/'.$resource->cover_page }}" height="250" width="250">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>

                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                @else
                    <h6 class="error text-center mt-5">Nous sommes désolés, mais la ressource que vous recherchez n'est pas encore disponible dans notre bibliothèque. Elle n'a surement pas encore été enregistrée. Veuillez vérifier ultérieurement pour voir si elle est disponible.</h6>
                @endif
            </div>
        </div>
    </section>

    <!-- Logout Modal-->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Détails de la ressource</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title">{{ $resourceDetails ? $resourceDetails->title : ""}}</h6>
                        </div>
                        <img src="{{ $resourceDetails ? '/storage/coverPages/'.$resourceDetails->cover_page : ""}}" alt="Photo de la ressource">
                        <div class="card-body">
                            <p class="card-text">Numéro d'identification : {{ $resourceDetails ? $resourceDetails->identification_number : ""}}</p>
                            <p class="card-text">Auteur :{{ $resourceDetails ? $resourceDetails->authors : ""}}</p>
                            <p class="card-text">Type : {{ $resourceDetails ? $resourceDetails->type->name : ""}}</p>
                            <p class="card-text">Sous Domaine : {{ $resourceDetails ? $resourceDetails->sub_category->name : ""}}</p>
                            <p class="card-text">Édition : {{ $resourceDetails ? $resourceDetails->edition : ""}}</p>
                            <p class="card-text">Localisation : {{ $resourceDetails ? $resourceDetails->institute->name : ""}}</p>
                            <p class="card-text">Nombre d'exemplaires : {{ $resourceDetails ? $resourceDetails->copies_number : ""}}</p>
                            <p class="card-text">Nombre disponibles : {{ $resourceDetails ? $resourceDetails->available_number : ""}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


