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

    public $searchInput = '';
    public $selections = [];
    public $hasNoActiveReservation = true;
    public $resourcesLength;
    public $currentInstitute;

    public $size = 0;
    public $extension = "";

    public function mount()
    {
        $user = User::find(Auth::user()->id);

        if(Auth::user()->role!="Bibliothécaire")
        {
            $lastReservation = $user->reservations()->latest()->first();
            $this->hasNoActiveReservation = (!$lastReservation) ? true : (($lastReservation->status != 'En cour') ? true : false);

            $registration = $user->registrations()->latest()->first();
            $this->currentInstitute = $registration->institute_id;
        }
        else
        {
            $this->currentInstitute = $user->institute->id;
        }

        $this->resourcesLength = ModelsResource::count();
    }

    public function updating($name, $value)
    {
        if($name === 'searchInput')
        {
            $this->resetPage();
        }
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
        sleep(1);

        $resource = ModelsResource::where('id', $currentResourceId)->firstOrFail();
        $this->size = Storage::size('public/digitalVersions/'.$resource->digital_version);
        $this->size = round($this->size / 1048576, 5);
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
        $resources = ModelsResource::resource()->where(function($query) {
            $query->where('identification_number', 'LIKE', '%'.$this->searchInput.'%')
            ->orWhere('registration_number', 'LIKE', '%'.$this->searchInput.'%')
            ->orWhere('title', 'LIKE', '%'.$this->searchInput.'%')
            ->orWhere('authors', 'LIKE', '%'.$this->searchInput.'%')
            ->orWhere('keywords', 'LIKE', '%'.$this->searchInput.'%')
            ->orWhere('ray', 'LIKE', '%'.$this->searchInput.'%')
            ->orWhere('edition', 'LIKE', '%'.$this->searchInput.'%')
            ->orWhere(function ($query) {
                $query->orWhereHas('type', function($subQuery) {
                    $subQuery->where('name', 'LIKE', '%'.$this->searchInput.'%');
                })->orWhereHas('sub_category', function($subQuery) {
                    $subQuery->where('name', 'LIKE', '%'.$this->searchInput.'%');
                });
            });
        })->orderByDesc('id')->paginate(10);

        return view('livewire.resource', [
            'resources' => $resources
        ]);
    }
}
