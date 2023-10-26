<div>
    <form action="/loans" method="POST">
        @csrf
        @if (!session()->has('reader_npi'))
            <div class="mb-3">
                <label for="preteur">Choisir le préteur :</label>
                <div class="form-check">
                    <input wire:click="showForm('Group')" class="form-check-input" type="radio" name="loaner" id="exampleRadios1" value="group" checked>
                    <label class="form-check-label" for="exampleRadios1">
                    Groupe
                    </label>
                </div>
                <div class="form-check">
                    <input wire:click="showForm('Reader')" class="form-check-input" type="radio" name="loaner" id="exampleRadios2" value="reader">
                    <label class="form-check-label" for="exampleRadios2">
                    Lecteur
                    </label>
                </div>
            </div>
        @endif

        @if ($loaner ==  "Group" && !session()->has('reader_npi'))
            <div class="row  mb-3">
                <div class="col-lg-6 col-12">
                    <div class="row">
                        <div class="col-12 input-group">
                            <span class="input-group-text" id="basic-addon2">Groupe<span class="text-danger fw-bold">*</span></span>
                            <select class="form-select flex-grow-1" id="inputGroupSelect01" required name="group_id">
                                <option value="">Choisir le groupe</option>
                                @foreach ($groups as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('group_id')
                            <div class="col-12 text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        @else
            <div class="row  mb-3">
                <div class="col-lg-6 col-12">
                    <div class="row">
                        <div class="col-12 input-group">
                            <span class="input-group-text" id="basic-addon2">NIP<span class="text-danger fw-bold">*</span></span>
                            <input type="text" class="form-control" placeholder="Entrez son NIP" autofocus aria-describedby="basic-addon1" required name="npi" value="{{ session()->has('reader_npi') ? session('reader_npi') : old('npi') }}">
                        </div>
                        @error('npi')
                            <div class="col-12 text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        @endif

        <div class="row mb-3">
            <div class="col-lg-6 col-12">
                <div class="row">
                    <div class="col-12 input-group">
                        <span class="input-group-text" id="basic-addon1">Date de fin<span class="text-danger fw-bold">*</span></span>
                        <input type="date" class="form-control" placeholder="Entrez la date de retour du livre" required name="end_date" value="{{ old('end_date') }}">
                    </div>
                    @error('end_date')
                        <div class="col-12 text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <button type="submit" class="btn mb-3" id="submit-btn">Enregistrer</button>
    </form>
</div>
