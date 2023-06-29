<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <form class="mt-3" wire:submit.prevent="sendMail">
        <div class="row mb-3">
            <div class="col-12 form-group">
                <input wire:model.defer="name" type="text" class="form-control" id="nameInput" placeholder="Votre nom et prénoms" required>
            </div>
            @error('name')
                <div class="col-12 text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="row mb-3">
            <div class="col form-group">
                <input wire:model.defer="email" type="email" class="form-control" id="emailInput" placeholder="Votre email" required>
            </div>
            @error('email')
                <div class="col-12 text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="row mb-3">
            <div class="form-group">
                <textarea wire:model.defer="message" class="form-control" id="messageInput" rows="5" placeholder="Votre message" required></textarea>
            </div>
            @error('message')
                <div class="col-12 text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-contact" wire:loading.attr="disabled">
            <span wire:loading>
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
            </span>
            Envoyer
        </button>
    </form>
</div>
