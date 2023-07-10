<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\SubCategory;

class CategoyAndSubCatagoryForm extends Component
{
    public $resource;
    public $category_id;

    public function mount()
    {
        $this->resource ? $this->category_id = $this->resource->sub_category->category_id : null;
    }

    public function render()
    {

        $sub_categories = SubCategory::where('category_id', $this->category_id ? intval($this->category_id) : intval($this->resource ? $this->resource->sub_category->category_id : 0))->orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('livewire.categoy-and-sub-catagory-form', [
            'sub_categories' => $sub_categories,
            'categories' => $categories
        ]);
    }
}
