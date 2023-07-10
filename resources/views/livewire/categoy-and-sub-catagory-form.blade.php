<div class="col-12">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="row">
                <div class="col-12 input-group d-flex">
                    <label class="input-group-text m-0" for="inputGroupSelect01">Domaine<span class="text-danger fw-bold">*</span></label>
                    <select class="form-select flex-grow-1" id="inputGroupSelect01" required name="category_id" wire:model="category_id" {{ Auth::user()->role === "Bibliothécaire" ? '' : ' disabled ' }}>
                        @if (!isset($resource) )
                            <option value="">Choisir son domaine</option>
                        @endif
                        @foreach ($categories as $category)
                            <option @isset($resource) @if($resource->sub_category->category_id == 2) selected @endif @endisset value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('category_id')
                    <div class="col-12 text-danger">Veuillez choisr le domaine de la ressource</div>
                @enderror
            </div>
        </div>

        <div class="col-12 mb-3">
            <div class="row">
                <div class="col-12 input-group d-flex">
                    <label class="input-group-text m-0" for="inputGroupSelect01">Sous domaine<span class="text-danger fw-bold">*</span></label>
                    <select class="form-select flex-grow-1" id="inputGroupSelect01" required name="sub_category_id" {{ Auth::user()->role === "Bibliothécaire" ? '' : ' disabled ' }}>
                        @if (!isset($resource))
                            <option value="" selected>Choisir son sous domaine</option>
                        @endif
                        @foreach ($sub_categories as $sub_category)
                            <option {{ (isset($resource) && ($resource->sub_category->id == $sub_category->id)) ? 'selected' : '' }} value="{{ $sub_category->id }}">{{ $sub_category->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('sub_category_id')
                    <div class="col-12 text-danger">Veuillez choisr le sous domaine de la ressource</div>
                @enderror
            </div>
        </div>
    </div>
</div>
