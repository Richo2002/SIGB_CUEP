<div x-data="{currentReaderId : null, currentReaderStatus: null}">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold" id="main-title">Liste des lecteurs</h6>
        </div>
        <div class="card-body">
            @if ($readersLength > 10)
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
                            <th>NPI</th>
                            <th>Nom Complet</th>
                            <th>Téléphone</th>
                            <th>Catégorie</th>
                            <th>Expire le</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    @if ($readers->count() > 0)
                        <tfoot>
                            <tr>
                                <th>NPI</th>
                                <th>Nom Complet</th>
                                <th>Téléphone</th>
                                <th>Catégorie</th>
                                <th>Expire le</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    @endif
                    <tbody>
                        @foreach ($readers as $index => $reader)
                            <tr wire:key="{{ $reader->id }}">
                                <td>{{ $reader->npi }}</td>
                                <td>{{ $reader->lastname." ".$reader->firstname }}</td>
                                <td>{{ $reader->phone_number }}</td>
                                <td>{{ $reader->role }}</td>
                                <td>{{ date('d-m-Y', strtotime($reader->registrations()->latest()->first()->end_date)) }}</td>
                                <td><i class="fa fa-circle {{ $reader->status ? 'actif' : 'inactif' }}"></i> {{ $reader->status ? 'Actif' : 'Inactif' }}</td>
                                <td class="d-flex">
                                    <a href="{{ '/readers/'.$reader->id.'/edit' }}" class="px-2 py-1" id="pen" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editer"><i class="fa fa-pen"></i></a>
                                    <a href="#" class="px-2 py-1" id="card" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editer sa carte"><i class="fa fa-id-card"></i></a>
                                    <a href="" wire:key="{{ $reader->id }}" x-on:click.prevent="currentReaderId = {{ $reader->id }}; currentReaderStatus = {{ $reader->status }}" class="px-2 py-1" id="{{ $reader->status ? 'ban' : 'check' }}" data-bs-toggle="tooltip" data-bs-placement="bottom" data-toggle="modal" data-target="#staticBackdrop" title="{{ $reader->status ? 'Désactiver son compte' : 'Activer son compte' }}">
                                        @if ($reader->status)
                                            <i class="fa fa-ban"></i>
                                        @else
                                            <i class="fa fa-check"></i>
                                        @endif
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex flex-row justify-content-between">
                {{ $readers->links() }}
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
                        <span x-show="!currentReaderStatus">d'activation</span>
                        <span x-show="currentReaderStatus">de désactivation</span>
                        du compte
                    </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Êtes-vous sûr de vouloir
                    <span x-show="!currentReaderStatus">activer</span>
                    <span x-show="currentReaderStatus">désactiver</span>
                        ce compte utilisateur ?
                    <span x-show="!currentReaderStatus">L'activation</span>
                    <span x-show="currentReaderStatus">La désactivation</span>
                        entraînera
                    <span x-show="!currentReaderStatus">l'ouverture</span>
                    <span x-show="currentReaderStatus">la suspension</span>
                        de l'accès et des fonctionnalités associées à ce compte.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                    <button x-on:click="$wire.changeStatus(currentReaderId, currentReaderStatus)" wire:loading.attr="disabled" class="btn btn-logout">
                        <span wire:loading>
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                        </span>
                        <span x-show="!currentReaderStatus">Activer</span>
                        <span x-show="currentReaderStatus">Désactiver</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
