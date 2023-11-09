<?php

namespace App\Http\Livewire;

use App\Models\Resource;
use Livewire\Component;
use Livewire\WithPagination;

class ResourcesSearched extends Component
{
    public $searchInput = '';

    use WithPagination;

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

    public function render()
    {

        $resources = Resource::where(function ($query) {
            $query->where('title', 'like', '%' . $this->searchInput . '%')
                ->orWhere('authors', 'like', '%' . $this->searchInput . '%')
                ->orWhere('keywords', 'like', '%' . $this->searchInput . '%')
                ->orWhere('edition', 'like', '%' . $this->searchInput . '%');
        })->orderByDesc('id')->paginate(6);

        return view('livewire.resources-searched', [
            'resources' => $resources,
            'resourcesLength' => count($resources) 
        ]);
    }
}
