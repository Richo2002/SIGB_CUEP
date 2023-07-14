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

    public $searchInput = '';

    protected $rules = [
        'name' => 'string|max:150|unique:categories',
        'classification_number' => 'required_with:name|regex:/^[0-9]+$/|unique:categories',
    ];

    public function mount()
    {
        $this->categoriesLength = Domain::count();
    }

    public function updating($name, $value)
    {
        if($name === 'searchInput')
        {
            $this->resetPage();
        }
    }


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

    public function render()
    {
        $categories = Domain::where('name', 'LIKE', '%'.$this->searchInput.'%')->orderByDesc('id')->paginate(10);

        return view('livewire.category', [
            'categories' => $categories
        ]);
    }
}
