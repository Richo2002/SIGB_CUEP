<div x-data="{currentMemberId : null}">

    @if (Auth::user()->role === "Bibliothécaire")
        <div class="row mb-4">

            <div class="col-12 input-group">
                <select class="form-select flex-grow-1" id="inputGroupSelect01" wire:model="reader_id">
                    <option value="">Choisir un membre du groupe</option>
                    @foreach ($readers as $reader)
                        <option value="{{ $reader->id }}">{{ $reader->lastname." ".$reader->firstname }}</option>
                    @endforeach
                </select>
                <button wire:click="store" class="btn" type="button" id="submit-btn">Ajouter</button>
            </div>
            @error('reader_id')
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
            <h6 class="m-0 font-weight-bold" id="main-title">Liste des membres du groupe {{ $group->name }}</h6>
        </div>
        <div class="card-body">
            @if ($membersLength > 10)
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
                            <th>Téléphone</th>
                            <th>Role</th>
                            <th>Statut</th>
                            @if (Auth::user()->role === "Bibliothécaire")
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Nom Complet</th>
                            <th>Téléphone</th>
                            <th>Role</th>
                            <th>Statut</th>
                            @if (Auth::user()->role === "Bibliothécaire")
                                <th>Action</th>
                            @endif
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr wire:key="{{ $group->responsable->id }}">
                            <td>{{ $group->responsable->lastname." ".$group->responsable->firstname }}</td>
                            <td>{{ $group->responsable->phone_number }}</td>
                            <td>{{ "Responsable" }}</td>
                            <td><i class="fa fa-circle {{ $group->responsable->status ? 'actif' : 'inactif' }}"></i> {{ $group->responsable->status ? 'Actif' : 'Inactif' }}</td>
                            @if (Auth::user()->role === "Bibliothécaire")
                                <td>
                                    <a href="#" class="px-2 py-1 disabled" id="trash" data-bs-toggle="tooltip" data-bs-placement="bottom" data-toggle="modal" data-target="#staticBackdrop" title="" ><i class="fa fa-trash"></i></a>
                                </td>
                            @endif
                        </tr>
                        @foreach ($members as $index => $member)
                            <tr wire:key="{{ $member->id }}">
                                <td>{{ $member->lastname." ".$member->firstname }}</td>
                                <td>{{ $member->phone_number }}</td>
                                <td>{{ "Membre" }}</td>
                                <td><i class="fa fa-circle {{ $member->status ? 'actif' : 'inactif' }}"></i> {{ $member->status ? 'Actif' : 'Inactif' }}</td>
                                @if (Auth::user()->role === "Bibliothécaire")
                                    <td>
                                        <a href="#" x-on:click.prevent="currentMemberId = {{ $member->id }};" class="px-2 py-1" id="trash" data-bs-toggle="tooltip" data-bs-placement="bottom" data-toggle="modal" data-target="#staticBackdrop" title="Retirer du groupe" ><i class="fa fa-trash"></i></a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex flex-row justify-content-between">
                {{ $members->links() }}
            </div>
        </div>
    </div>
    <div class="modal fade" id="staticBackdrop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Confirmation de retrait d'utilisateur du groupe
                    </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Êtes-vous sûr de vouloir retirer cet utilisateur du groupe ? L'utilisateur ne fera plus partie du groupe.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                    <button x-on:click="$wire.remove(currentMemberId, {{ $group->id }})" wire:loading.attr="disabled" class="btn btn-logout">
                        <span wire:loading>
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                        </span>
                        Retirer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
