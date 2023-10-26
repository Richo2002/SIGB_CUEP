<div x-data="{currentTypeId : null}">

    <div class="row mb-4">
        <div class="col-12 input-group">
            <input wire:model="name" type="text" class="form-control" placeholder="Entrez un type de ressource" aria-label="Type" autofocus aria-describedby="basic-addon1">
            <button wire:click="store" class="btn" type="button" id="submit-btn">Ajouter</button>
        </div>
        @error('name')
            <div class="col-12 text-danger">{{ $message }}</div>
        @enderror
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold" id="main-title">Liste des types</h6>
        </div>
        <div class="card-body">
            @if ($typesLength > 10)
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
                            <th>Nom Complet</th>
                            <th>Ressource</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    @if ($types->count() > 0)
                        <tfoot>
                            <tr>
                                <th>Nom Complet</th>
                                <th>Ressource</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    @endif
                    <tbody>
                        @foreach ($types as $index => $type)
                            <tr wire:key="{{ $type->id }}">
                                <td>{{ $type->name }}</td>
                                <td>{{ count($type->resources) }}</td>
                                <td class="d-flex">
                                    <a href="{{ '/types/'.$type->id.'/edit' }}" class="px-2 py-1" id="pen" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editer"><i class="fa fa-pen"></i></a>
                                    <a href="#" x-on:click.prevent="currentTypeId = {{ $type->id }}" class="px-2 py-1{{ (count($type->resources) > 0) ? ' disabled' : '' }}" id="trash" data-bs-toggle="tooltip" data-bs-placement="bottom" data-toggle="modal" data-target="#staticBackdrop" title="{{ (count($type->resources) > 0) ? '' : 'Supprimer' }}" ><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex flex-row justify-content-between">
                    {{ $types->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="staticBackdrop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmation de suppression</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Êtes-vous sûr de vouloir continuer ? Cette action est irréversible et les données supprimées ne pourront pas être récupérées.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                    <button x-on:click="$wire.delete(currentTypeId)" wire:loading.attr="disabled" class="btn btn-logout">
                        <span wire:loading>
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                        </span>
                        Supprimer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
