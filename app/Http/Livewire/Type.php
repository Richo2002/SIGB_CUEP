<?php

namespace App\Http\Livewire;

use App\Models\Type as Genre;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class Type extends Component
{
    use WithPagination;

    public $name;
    public $searchInput;
    public $typesLength;

    protected $types;

    protected $rules = [
        'name' => 'string|max:50|unique:types',
    ];

    public function store()
    {
        if(!empty($this->name))
        {
            $this->validate();

            Genre::create(['name' => $this->name]);

            $this->name = "";

            session()->flash('message', 'Enrégistrement réussi');
            $this->resetPage();
        }
    }

    public function updatedSearchInput()
    {
        $this->types = Genre::where('name', 'LIKE', '%'.$this->searchInput.'%')->orderByDesc('id')->paginate(10);
    }

    public function paginationView()
    {
        return 'livewire.pagination';
    }

    public function delete(int $currentTypeId)
    {
        $type = Genre::findOrFail($currentTypeId);
        $type->delete();

        session()->flash('message', 'Suppression réussie');
        $this->emit('closeModal');

        $this->resetPage();
    }

    public function render()
    {
        if(!$this->searchInput)
        {
            $this->types = Genre::orderByDesc('id')->paginate(10);
            $this->typesLength = $this->types->total();
        }

        return view('livewire.type', [
            'types' => $this->types
        ]);
    }
}
