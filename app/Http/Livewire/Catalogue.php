<?php

namespace App\Http\Livewire;

use App\Models\Type;
use Livewire\Component;
use App\Models\Category;
use App\Models\Resource;
use App\Models\SubCategory;

class Catalogue extends Component
{
    protected $resources = [];

    public $typeSelect;
    public $subCategorySelect;
    public $searchInput;
    public $resourceDetails;
    public $categorySelect;
    public $subCategories = [];

    public function sortOrSearchResource()
    {
        $resourcesQuery = Resource::query();

        if ($this->subCategorySelect) {
            $resourcesQuery->where('sub_category_id', intval($this->subCategorySelect));
        }

        if ($this->categorySelect) {
            $resourcesQuery->whereHas('sub_category', function($query) {
                $query->where('category_id', intval($this->categorySelect));
            });

            $this->subCategories = SubCategory::where('category_id', intval($this->categorySelect))->get();
        }

        if ($this->typeSelect) {
            $resourcesQuery->where('type_id', intval($this->typeSelect));
        }

        if ($this->searchInput) {
            $resourcesQuery->where(function ($query) {
                $query->where('title', 'like', '%' . $this->searchInput . '%')
                    ->orWhere('authors', 'like', '%' . $this->searchInput . '%')
                    ->orWhere('keywords', 'like', '%' . $this->searchInput . '%')
                    ->orWhere('edition', 'like', '%' . $this->searchInput . '%');
            });
        }

        $this->resources = $resourcesQuery->orderByDesc('id')->get();

        $this->dispatchBrowserEvent('contentChanged');
    }


    public function updatedSearchInput()
    {
        $this->sortOrSearchResource();
    }


    public function showDetails($id)
    {
        $this->resourceDetails = Resource::where('id', intval($id))->first();
    }


    public function render()
    {
        $this->sortOrSearchResource();

        $types = Type::all();
        $categories = Category::all();

        return view('livewire.catalogue', [
            'types' => $types,
            'categories' => $categories,
            'resources' => $this->resources,
        ]);
    }
}
