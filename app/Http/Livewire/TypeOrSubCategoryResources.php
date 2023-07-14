<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Resource;

class TypeOrSubCategoryResources extends Component
{
    public $searchInput = '';
    public $resourcesLength;
    public $typeOrSubCategoryId;
    public $column;

    public function mount()
    {
        $this->resourcesLength = Resource::count();
    }

    public function render()
    {
        $resources = Resource::where(function ($query) {
            $query->where('title', 'like', '%' . $this->searchInput . '%')
                ->orWhere('authors', 'like', '%' . $this->searchInput . '%')
                ->orWhere('keywords', 'like', '%' . $this->searchInput . '%')
                ->orWhere('edition', 'like', '%' . $this->searchInput . '%');
        })->where($this->column, $this->typeOrSubCategoryId)->orderByDesc('id')->paginate(6);

        return view('livewire.type-or-sub-category-resources', [
            'resources' => $resources,
        ]);
    }
}
