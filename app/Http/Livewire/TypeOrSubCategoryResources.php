<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Resource;

class TypeOrSubCategoryResources extends Component
{
    protected $resources = [];

    public $searchInput;
    public $resourcesLength;
    public $typeOrSubCategoryId;
    public $column;


    public function sortOrSearchResource()
    {
        $resourcesQuery = Resource::query();

        if ($this->searchInput) {
            $resourcesQuery->where(function ($query) {
                $query->where('title', 'like', '%' . $this->searchInput . '%')
                    ->orWhere('authors', 'like', '%' . $this->searchInput . '%')
                    ->orWhere('keywords', 'like', '%' . $this->searchInput . '%')
                    ->orWhere('edition', 'like', '%' . $this->searchInput . '%');
            });
        }
        else
        {

            $this->resources = $resourcesQuery->where($this->column, $this->typeOrSubCategoryId)->orderByDesc('id')->paginate(6);
            $this->resourcesLength = $this->resources->total();
        }

        $this->resources = $resourcesQuery->where($this->column, $this->typeOrSubCategoryId)->orderByDesc('id')->paginate(6);
    }


    public function updatedSearchInput()
    {
        $this->sortOrSearchResource();
    }


    public function render()
    {
        $this->sortOrSearchResource();

        return view('livewire.type-or-sub-category-resources', [
            'resources' => $this->resources,
        ]);
    }
}
