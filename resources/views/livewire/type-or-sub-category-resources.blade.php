<div>
    @if ($resourcesLength > 12)
        <div class="row mb-3">
            <div class="col-12">
                <div class="input-group" id="searchInput">
                    <input type="text" class="form-control p-2" placeholder="Rechercher par mot clé, auteur, titre" wire:model.debounce.150ms="searchInput">
                    <span class="input-group-text d-block p-2 h-100"><i class="fa fa-search"></i></span>
                </div>
            </div>
        </div>
    @endif


    <div class="row g-3 mb-3">
        @if (count($resources) > 0)
            @foreach ($resources as $resource)
                <div class="col-lg-6 col-12">
                    <div class="card" style="min-height: 200px">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="/storage/coverPages/{{ $resource->cover_page }}" class="img-fluid rounded-start" alt="" style="height: 210px">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $resource->authors }}</h5>
                                    <p class="card-text">{{ Str::words($resource->title, 10, ' ...') }}</p>
                                    <p class="card-text"><small class="text-muted">Ajouté le {{ date('d-m-Y', strtotime($resource->created_at)) }}</small></p>
                                    <a href="/resources/{{ $resource->id }}" class="btn see-more-btn">Voir plus</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <h6 class="error text-center mt-5">Nous sommes désolés, mais la ressource que vous recherchez n'est pas encore disponible dans notre bibliothèque. Veuillez vérifier ultérieurement pour voir si elle est disponible.</h6>
        @endif

    </div>

    <div>
        {{ $resources->links() }}
    </div>
</div>
