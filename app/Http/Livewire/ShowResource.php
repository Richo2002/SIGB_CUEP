<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Resource;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ShowResource extends Component
{
    public $reservationId;

    public function download($digitalVersion)
    {
        session()->flash('message', 'Le téléchargement a été lancé avec succès.');

        return Storage::download('public/digitalVersions/'.$digitalVersion);
    }

    public function render()
    {
        $resource = Resource::findOrFail($this->reservationId);
        $size = Storage::size('public/digitalVersions/'.$resource->digital_version);
        $size = round($size / 1048576, 5);
        $extension = File::extension('public/digitalVersions/'.$resource->digital_version);

        return view('livewire.show-resource', [
            'resource' => $resource,
            'size' => $size,
            'extension' => $extension,
        ]);
    }
}
