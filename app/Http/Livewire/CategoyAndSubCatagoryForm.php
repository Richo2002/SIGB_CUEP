<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;

class CategoyAndSubCatagoryForm extends Component
{
    public $resource;
    public $category_id;
    public $sub_category_id;

    public function render()
    {
        if($this->resource)
        {
            $this->category_id = $this->resource->sub_category ? $this->resource->sub_category->category_id : $this->resource->sub_sub_category->sub_category->category_id;
            $this->sub_category_id = $this->resource->sub_category ? $this->resource->sub_category_id : $this->resource->sub_sub_category->sub_category_id;
        }

        $sub_sub_categories = SubSubCategory::where('sub_category_id', $this->sub_category_id ?? 0)->orderBy('name')->get();
        $sub_categories = SubCategory::where('category_id', $this->category_id ?? 0)->orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        // dd(count($sub_sub_categories), count($sub_categories));

        return view('livewire.categoy-and-sub-catagory-form', [
            'sub_categories' => $sub_categories,
            'categories' => $categories,
            'sub_sub_categories' => $sub_sub_categories,
        ]);
    }
}
