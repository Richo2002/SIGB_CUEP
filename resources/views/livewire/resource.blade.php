<div x-data="{ selections: @entangle('selections').defer, currentResourceId : null, currentResourceStatus: null, currentResourceAuthors: null, currentResourceDigitalVersion: null}">

    <div>
        @if (Auth::user()->role=="Bibliothécaire")
            <a href="/resources/create" class="btn mb-4" id="submit-btn">Ajouter</a>
        @endif
        @if (Auth::user()->role=="Bibliothécaire")
            <a x-show="selections.length > 0" href="" class="btn mb-4" id="loan-btn" x-on:click.prevent="$wire.lend(selections)">
                Prêter ressources (<span x-text="selections.length"></span>)
            </a>
        @else
            <a x-show="selections.length > 0" href="" class="btn mb-4" id="loan-btn" x-on:click.prevent="$wire.book(selections)">
                Réserver ressources (<span x-text="selections.length"></span>)
            </a>
        @endif
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold" id="main-title">Liste des ressources</h6>
        </div>
        <div class="card-body">
            @if ($resourcesLength > 10)
                <div class="row d-flex flex-direction-row justify-content-end">
                    <div class="col-md-6 col-12 mb-3">
                        <input type="text" class="form-control" id="filter-author" placeholder="Rechercher" wire:model.debounce.150ms="searchInput">
                    </div>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Uid</th>
                            <th>Photo</th>
                            <th>Titre</th>
                            <th>Sous Domaine</th>
                            <th>Type</th>
                            <th>Auteur</th>
                            <th>Page</th>
                            <th>Disponibilité</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    @if ($resources->count() > 0)
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>Uid</th>
                                <th>Photo</th>
                                <th>Titre</th>
                                <th>Sous Domaine</th>
                                <th>Type</th>
                                <th>Auteur</th>
                                <th>Page</th>
                                <th>Disponibilité</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    @endif
                    <tbody>
                        @foreach ($resources as $index => $resource)
                            <tr>
                                <td>
                                    <input x-model="selections" type="checkbox" value="{{ $resource->id }}" {{ ($resource->available_number > 0 && $resource->status == true && $hasNoActiveReservation == true && $currentInstitute == $resource->institute_id) ? '' : 'disabled' }}>
                                </td>
                                <td>{{ $resource->id }}</td>
                                <td>
                                    <div>
                                        <img src="{{ '/storage/coverPages/'.$resource->cover_page }}" width="50px" height="50px" alt="" style="object-fit: contain">
                                    </div>
                                </td>
                                <td>{{ $resource->title }}</td>
                                <td>{{ $resource->sub_category->name }}</td>
                                <td>{{ $resource->type->name }}</td>
                                <td>{{ $resource->authors }}</td>
                                <td>{{ $resource->page_number }}</td>
                                <td><i class="fa fa-circle {{ $resource->available_number > 0 ? 'actif' : 'inactif' }}"></i> {{ $resource->status > 0 ? 'actif' : 'inactif' }}</td>
                                <td class="d-flex">
                                    <a href="{{ '/resources/'.$resource->id.'/edit' }}" class="px-2 py-1" id="pen" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editer"><i class="fa fa-pen"></i></a>
                                    <a href="" x-on:click.prevent="currentResourceAuthors = '{{ $resource->authors }}'; currentResourceDigitalVersion = '{{ $resource->digital_version }}'" wire:click.prevent="getFileDetails({{ $resource->id }})" class="px-2 py-1 {{ $resource->digital_version ? '' : 'disabled' }}" id="download" data-bs-toggle="tooltip" data-bs-placement="bottom" data-toggle="modal" data-target="#staticBackdrop2" title="Téléchargement"><i class="fa fa-download"></i></a>
                                    @if (Auth::user()->role=="Bibliothécaire")
                                        <a href="" wire:key="{{ $resource->id }}" x-on:click.prevent="currentResourceId = {{ $resource->id }}; currentResourceStatus = {{ $resource->status }}" class="px-2 py-1{{ ($resource->available_number != $resource->copies_number) ? ' disabled' : '' }}" id="{{ $resource->status ? 'ban' : 'check' }}" data-bs-toggle="tooltip" data-bs-placement="bottom" data-toggle="modal" data-target="#staticBackdrop" title="{{ $resource->status ? 'Désactiver la resource' : 'Activer la resource' }}">
                                            @if ($resource->status)
                                                <i class="fa fa-ban"></i>
                                            @else
                                                <i class="fa fa-check"></i>
                                            @endif
                                        </a>
                                    @endif

                                </td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex flex-row justify-content-between">
                {{ $resources->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="staticBackdrop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Confirmation
                        <span x-show="!currentResourceStatus">de l'activation</span>
                        <span x-show="currentResourceStatus">de désactivation</span>
                        de ressource
                    </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Êtes-vous sûr de vouloir
                    <span x-show="!currentResourceStatus">activer</span>
                    <span x-show="currentResourceStatus">désactiver</span>
                        cette ressource ?  Une fois,
                    <span x-show="!currentResourceStatus">activée, elle sera</span>
                    <span x-show="currentResourceStatus">désactivée, elle ne sera plus</span>
                    disponible pour les emprunts
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                    <button x-on:click="$wire.changeStatus(currentResourceId, currentResourceStatus)" wire:loading.attr="disabled" wire:target="delete" class="btn btn-logout">
                        <span x-show="!currentResourceStatus">Activer</span>
                        <span x-show="currentResourceStatus">Désactiver</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="staticBackdrop2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Télérchargement de resource
                    </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir télécharger la ressource de : <span x-html="currentResourceAuthors"></span> au format {{ $extension }} d'une taille de {{ $size }} Mo?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                    <button x-on:click="$wire.download(currentResourceDigitalVersion)" wire:loading.attr="disabled" wire:target="delete" class="btn btn-logout">
                        Télercharger
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
