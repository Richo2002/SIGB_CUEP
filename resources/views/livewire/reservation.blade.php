<div x-data="{currentReservationId : null}">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold" id="main-title">Liste des réservations</h6>
        </div>
        <div class="card-body">
            @if ($reservationsLength > 100)
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
                    @if (count($reservations) > 0)
                        <tfoot>
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
                        </tfoot>
                    @endif
                    <tbody>
                        @foreach ($reservations as $index => $reservation)
                            <tr wire:key="{{ $reservation->id }}">
                                <td>{{ $reservation->reader->lastname." ".$reservation->reader->firstname }}</td>
                                <td>
                                    {{ count($reservation->resources) }}<a href="" wire:click.prevent="getReservedResources({{ $reservation->id }})" class="px-2 py-1" id="eye" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Voir les resources" data-toggle="modal" data-target="#staticBackdrop2"><i class="fa fa-eye" x-cloack></i></a>
                                </td>
                                <td>{{ $reservation->start_date }}</td>
                                <td>{{ date('d-m-Y', strtotime($reservation->end_date)) }}</td>
                                @if ($reservation->status == "En cour" )
                                    <td><i class="fa fa-circle actif"></i> En cour</td>
                                @else
                                    <td>{{ $reservation->status }}</td>
                                @endif
                                @if (Auth::user()->role=="Bibliothécaire")
                                    <td class="d-flex">
                                        <a href="" x-on:click.prevent="$wire.lend({{ $reservation->id }})" class="px-2 py-1{{ $reservation->status != "En cour" ? ' disabled' : '' }}" id="return" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Prétés les resources"><i class="fa fa-shopping-cart"></i></a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex flex-row justify-content-between">
                {{ $reservations->links() }}
            </div>
        </div>
    </div>
    <div class="modal fade" id="staticBackdrop2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Ressources réservées
                    </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                   <p wire:loading wire:target="getReservedResources">Chargement ...</p>
                   <ul wire:loading.remove wire:target="getReservedResources">
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
