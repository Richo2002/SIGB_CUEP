<div x-data="{currentLoanId : null}">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

     <!-- DataTales Example -->
     <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold" id="main-title">Liste des prêts</h6>
        </div>
        <div class="card-body">
            @if ($loansLength > 10)
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
                            <th>Lecteur/Groupe</th>
                            <th>Nombre</th>
                            <th>Date de début</th>
                            <th>Date de fin</th>
                            <th>Statut</th>
                            @if (Auth::user()->role=="Bibliothécaire")
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tfoot>
                        @if (count($loans) > 0)
                            <tr>
                                <th>Lecteur/Groupe</th>
                                <th>Nombre</th>
                                <th>Date de début</th>
                                <th>Date de fin</th>
                                <th>Statut</th>
                                @if (Auth::user()->role=="Bibliothécaire")
                                    <th>Action</th>
                                @endif
                            </tr>
                        @endif
                    </tfoot>
                    <tbody>
                        @foreach ($loans as $index => $loan)
                            <tr>
                                <td>{{ $loan->reader ? $loan->reader->lastname." ".$loan->reader->firstname : $loan->group->name}}</td>
                                <td>
                                    {{ count($loan->resources) }}<a href="" wire:click.prevent="getLoanedResources({{ $loan->id }})" class="px-2 py-1" id="eye" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Voir les resources" data-toggle="modal" data-target="#staticBackdrop2"><i class="fa fa-eye"></i></a>
                                </td>
                                <td>{{ $loan->start_date }}</td>
                                <td>{{ date('d-m-Y', strtotime($loan->end_date)) }}</td>
                                @if ($loan->status == "Retard" )
                                    <td><i class="fa fa-circle inactif"></i></td>
                                @else
                                    <td>{{ $loan->status }}</td>
                                @endif
                                @if (Auth::user()->role=="Bibliothécaire")
                                    <td class="d-flex">
                                        <a href="" x-on:click.prevent="currentLoanId = {{ $loan->id }}" class="px-2 py-1{{ $loan->status == "Terminé" ? ' disabled' : '' }}" id="return" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Récupérer les resources" data-toggle="modal" data-target="#staticBackdrop"><i class="fa fa-check-circle"></i></a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex flex-row justify-content-between">
                {{ $loans->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="staticBackdrop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Confirmation de recupération de ressource
                    </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Êtes-vous sûr de vouloir récupérer les ressources prêtées ? Cette action est irréversible.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                    <button x-on:click="$wire.retrieve(currentLoanId)" wire:loading.attr="disabled" wire:target="get" class="btn btn-logout">
                        Récupérer
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
                        Ressources prêtées
                    </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                   <ul>
                        @foreach ($resources as $resource)
                            <li>{{ $resource->type->name." : ".$resource->title }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
</div>
