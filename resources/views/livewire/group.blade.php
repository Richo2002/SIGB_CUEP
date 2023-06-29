<div x-data="{currentGroupId : null}">
    @if (Auth::user()->role === "Bibliothécaire")
        <div class="row mb-4">

            <div class="col-12 input-group">
                <input wire:model="name" type="text" class="form-control" placeholder="Entrez un nom de groupe" autofocus>
                <select class="form-select flex-grow-1" id="inputGroupSelect01" wire:model="responsable_id">
                    <option value="">Choisir le responsable du groupe</option>
                    @foreach ($readers as $reader)
                        <option value="{{ $reader->id }}">{{ $reader->lastname." ".$reader->firstname }}</option>
                    @endforeach
                </select>
                <button wire:click="store" class="btn" type="button" id="submit-btn">Ajouter</button>
            </div>

            @error('name')
                <div class="col-12 text-danger">{{ $message }}</div>
            @enderror
            @error('responsable_id')
                <div class="col-12 text-danger">{{ $message }}</div>
            @enderror

        </div>
    @endif

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold" id="main-title">Liste des groupes</h6>
        </div>
        <div class="card-body">
            @if ($groupsLength > 10)
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
                            <th>Uid</th>
                            <th>Nom</th>
                            <th>Membre</th>
                            <th>Responsable</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    @if ($groups->count() > 0)
                        <tfoot>
                            <tr>
                                <th>Uid</th>
                                <th>Nom</th>
                                <th>Membre</th>
                                <th>Responsable</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    @endif
                    <tbody>
                        @foreach ($groups as $index => $group)
                            <tr>
                                <td>{{ $group->id }}</td>
                                <td>{{ $group->name }}</td>
                                <td>{{ count($group->readers) + 1 }}</td>
                                <td>{{ $group->responsable->lastname." ".$group->responsable->firstname }}</td>
                                <td class="d-flex">
                                    @if (Auth::user()->role === "Bibliothécaire")
                                        <a href="{{ '/groups/'.$group->id.'/edit' }}" class="px-2 py-1" id="pen" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editer"><i class="fa fa-pen"></i></a>
                                    @endif
                                    <a href="{{ route('groups.members.index', $group->id) }}" class="px-2 py-1" id="member" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Membre du groupe"><i class="fa fa-people-group"></i></a>
                                    @if (Auth::user()->role === "Bibliothécaire")
                                        <a href="#" x-on:click.prevent="currentGroupId = {{ $group->id }};" class="px-2 py-1" id="trash" data-bs-toggle="tooltip" data-bs-placement="bottom" data-toggle="modal" data-target="#staticBackdrop" title="{{ (count($group->loans) > 0 && count($group->readers) > 0 ) ? '' : 'Supprimer' }}" ><i class="fa fa-trash"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex flex-row justify-content-between">
                {{ $groups->links() }}
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
                    <button x-on:click="$wire.delete(currentGroupId)" wire:loading.attr="disabled" wire:target="delete" class="btn btn-logout">
                        Supprimer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
