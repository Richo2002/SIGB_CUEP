<?php

namespace App\Http\Livewire;

use App\Models\Group as Team;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Group extends Component
{
    use WithPagination;

    public $name;
    public $responsable_id;
    public $groupsLength;

    public $searchInput;
    protected $groups;

    protected $rules = [
        'name' => 'string|max:100|unique:groups',
        'responsable_id' => 'required_if:has_name,1',
    ];


    public function store()
    {
        if(!empty($this->name))
        {
            $this->validate();

            Team::create([
                'name' => $this->name,
                'responsable_id' => $this->responsable_id
            ]);

            $this->name = "";
            $this->responsable_id = "";

            session()->flash('message', 'Enrégistrement réussi');
            $this->resetPage();

        }
    }


    public function paginationView()
    {
        return 'livewire.pagination';
    }

    public function updatedSearchInput()
    {
        $this->groups = Team::where('name', 'LIKE', '%'.$this->searchInput.'%')
                            ->orWhereHas('responsable', function($query) {
                                $query->where('lastname', 'LIKE', '%'.$this->searchInput.'%')
                                ->orWhere('firstname', 'LIKE', '%'.$this->searchInput.'%');
                            })->paginate(10);
    }

    public function delete(int $currentGroupId)
    {
        $group = Team::findOrFail($currentGroupId);
        $group->delete();

        session()->flash('message', 'Suppression réussie');
        $this->emit('closeModal');

        $this->resetPage();

    }

    public function render()
    {

        $readers = User::where([['role', '<>' ,'Administrateur'], ['role', '<>' ,'Bibliothécaire']])
            ->whereDoesntHave('group')
            ->orderBy('lastname')
            ->get();

        if(!$this->searchInput)
        {
            $this->groups = Team::orderByDesc('id')->paginate(10);
            $this->groupsLength = $this->groups->total();

        }


        return view('livewire.group', [
            'readers' => $readers,
            'groups' => $this->groups
        ]);
    }
}
