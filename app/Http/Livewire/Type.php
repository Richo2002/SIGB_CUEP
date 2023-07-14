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
    public $searchInput = '';
    public $typesLength;

    protected $rules = [
        'name' => 'string|max:50|unique:types',
    ];

    public function mount()
    {
        $this->typesLength = Genre::count();
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

            Genre::create(['name' => $this->name]);

            $this->name = "";

            session()->flash('message', 'Enrégistrement réussi');
            $this->resetPage();
        }
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
        $types = Genre::where('name', 'LIKE', '%'.$this->searchInput.'%')->orderByDesc('id')->paginate(10);

        return view('livewire.type', [
            'types' => $types
        ]);
    }
}
