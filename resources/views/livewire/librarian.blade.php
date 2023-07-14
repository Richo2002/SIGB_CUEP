<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold" id="main-title">Liste des bibliothécaires</h6>
        </div>
        <div class="card-body">
            @if ($librariansLength > 10)
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
                            <th>Email</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    @if (count($librarians) > 0)
                        <tfoot>
                            <tr>
                                <th>Nom Complet</th>
                                <th>Téléphone</th>
                                <th>Email</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    @endif
                    <tbody>
                        @foreach ($librarians as $index => $librarian)
                            <tr>
                                <td>{{ $librarian->lastname." ".$librarian->firstname }}</td>
                                <td>{{ $librarian->phone_number }}</td>
                                <td>{{ $librarian->email }}</td>
                                <td><i class="fa fa-circle {{ $librarian->status ? 'actif' : 'inactif' }}"></i> {{ $librarian->status ? 'Actif' : 'Inactif' }}</td>
                                <td class="d-flex">
                                    <a href="{{ '/librarians/'.$librarian->id.'/edit' }}" class="px-2 py-1" id="pen" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editer"><i class="fa fa-pen"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex flex-row justify-content-between">
                {{ $librarians->links() }}
            </div>
        </div>
    </div>
</div>
