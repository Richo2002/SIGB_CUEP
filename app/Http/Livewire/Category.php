<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\Category as Domain;
use Livewire\WithPagination;

class Category extends Component
{
    use WithPagination;

    public $name;
    public $classification_number;
    public $categoriesLength;

    public $searchInput;
    protected $categories;

    protected $rules = [
        'name' => 'string|max:150|unique:categories',
        'classification_number' => 'required_if:has_name,1|regex:/^[0-9]+$/|unique:categories',
    ];


    public function store()
    {
        if(!empty($this->name))
        {
            $this->validate();

            Domain::create([
                'name' => $this->name,
                'classification_number' => $this->classification_number
            ]);

            $this->name = "";
            $this->classification_number = "";

            session()->flash('message', 'Enregistrement réussi');
            $this->resetPage();


        }
    }

    public function delete(int $currentCategoryId)
    {
        $category = Domain::findOrFail($currentCategoryId);
        $category->delete();

        session()->flash('message', 'Suppression réussie');
        $this->emit('closeModal');

        $this->resetPage();

    }

    public function paginationView()
    {
        return 'livewire.pagination';
    }

    public function updatedSearchInput()
    {
        $this->categories = Domain::where('name', 'LIKE', '%'.$this->searchInput.'%')->orderByDesc('id')->paginate(10);
    }

    public function render()
    {
        if(!$this->searchInput)
        {
            $this->categories = Domain::orderByDesc('id')->paginate(10);
            $this->categoriesLength = $this->categories->total();
        }

        return view('livewire.category', [
            'categories' => $this->categories
        ]);
    }
}
