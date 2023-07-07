<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Group as Team;
use Illuminate\Support\Facades\Auth;

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
        'responsable_id' => 'required_with:name',
    ];


    public function store()
    {
        if(!empty($this->name))
        {
            $this->validate();

            $user = User::find(Auth::user()->id);

            Team::create([
                'name' => $this->name,
                'responsable_id' => $this->responsable_id,
                'institute_id' => $user->institute->id,
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
        $this->groups = Team::group()->where('name', 'LIKE', '%'.$this->searchInput.'%')
                            ->orWhereHas('responsable', function($query) {
                                $query->where('lastname', 'LIKE', '%'.$this->searchInput.'%')
                                ->orWhere('firstname', 'LIKE', '%'.$this->searchInput.'%');
                            })->orderByDesc('id')
                            ->paginate(10);
    }

    public function delete(int $currentGroupId)
    {
        $group = Team::findOrFail($currentGroupId);
        $group->readers()->detach();
        $group->delete();

        session()->flash('message', 'Suppression réussie');
        $this->emit('closeModal');

        $this->resetPage();

    }

    public function render()
    {

        if(Auth::user()->role==="Bibliothécaire")
        {
            $readers = User::user()->where([['role', '<>' ,'Administrateur'], ['role', '<>' ,'Bibliothécaire']])
            ->whereDoesntHave('group')
            ->orderByDesc('lastname')
            ->get();
        }

        if(!$this->searchInput)
        {
            $this->groups = Team::group()->orderByDesc('id')->paginate(10);
            $this->groupsLength = $this->groups->total();

        }


        return view('livewire.group', [
            'readers' => $readers ?? null,
            'groups' => $this->groups
        ]);
    }
}
