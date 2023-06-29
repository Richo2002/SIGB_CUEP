<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Resource as ModelsResource;

class Resource extends Component
{
    use WithPagination;

    public $searchInput;
    public $selections = [];
    public $hasNoActiveReservation = true;
    public $resourcesLength;


    protected $resources;

    public $size = 0;
    public $extension = "";

    public function mount()
    {
        if(Auth::user()->role!="Bibliothécaire")
        {
            $user = User::find(Auth::user()->id);
            $lastReservation = $user->reservations()->latest()->first();
            $this->hasNoActiveReservation = $lastReservation ? $lastReservation->where('status', '<>', 'En cour')->exists() : true;
        }
    }

    public function updatedSearchInput()
    {
        $this->resources = ModelsResource::where('identification_number', 'LIKE', '%'.$this->searchInput.'%')
                                    ->orWhere('registration_number', 'LIKE', '%'.$this->searchInput.'%')
                                    ->orWhere('title', 'LIKE', '%'.$this->searchInput.'%')
                                    ->orWhere('authors', 'LIKE', '%'.$this->searchInput.'%')
                                    ->orWhere('keywords', 'LIKE', '%'.$this->searchInput.'%')
                                    ->orWhere('ray', 'LIKE', '%'.$this->searchInput.'%')
                                    ->orWhere('edition', 'LIKE', '%'.$this->searchInput.'%')
                                    ->orWhereHas('type', function($query) {
                                        $query->where('name', 'LIKE', '%'.$this->searchInput.'%');
                                    })->orWhereHas('sub_category', function($query) {
                                        $query->where('name', 'LIKE', '%'.$this->searchInput.'%');
                                    })
                                    ->orderByDesc('id')->paginate(10);
    }

    public function paginationView()
    {
        return 'livewire.pagination';
    }

     public function lend(array $selections)
    {
        session(['selections' => $selections]);
        $this->selections = [];
        return redirect()->route('loans.create');
    }

    public function book(array $selections)
    {
        session(['selections' => $selections]);
        $this->selections = [];
        return redirect()->route('reservations.create');
    }

    public function changeStatus(int $currentResourceId, bool $status)
    {
        $resource = ModelsResource::where('id', $currentResourceId)->firstOrFail();

        $status ? $resource->status = false : $resource->status = true;

        $resource->save();

        session()->flash('message', $status ? 'Désactivation de ressource réussie' : 'Activation de ressource réussie');

        $this->emit('closeModal');

        $this->resetPage();
    }

    public function getFileDetails($currentResourceId)
    {
        $resource = ModelsResource::where('id', $currentResourceId)->firstOrFail();

        $this->size = Storage::size('public/digitalVersions/'.$resource->digital_version);
        $this->size = round($this->size / 1048576, 2);
        $this->extension = File::extension('public/digitalVersions/'.$resource->digital_version);
    }

    public function download($digitalVersion)
    {
        session()->flash('message', 'Le téléchargement a été lancé avec succès.');

        $this->emit('closeModal');

        return Storage::download('public/digitalVersions/'.$digitalVersion);
    }


    public function render()
    {
        if(!$this->searchInput)
        {
            $this->resources = ModelsResource::paginate(10);
            $this->resourcesLength = $this->resources->total();
        }


        return view('livewire.resource', [
            'resources' => $this->resources
        ]);
    }
}
