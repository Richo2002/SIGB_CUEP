<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Member extends Component
{
    use WithPagination;

    public $group;
    public $reader_id;
    public $membersLength;

    public $searchInput = '';

    public function mount()
    {
        $this->membersLength = User::whereHas('groups', function($query) {
            $query->where('groups.id', $this->group->id);
        })->count();
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
        if($this->reader_id!="")
        {
            $reader = User::findOrFail($this->reader_id);
            $reader->groups()->attach($this->group->id);

            $this->reader_id = "";

            session()->flash('message', 'Enrégistrement réussi');
            $this->resetPage();
        }
    }

    public function remove(int $currentMemberId, int $currentGroupId)
    {
        $reader = User::findOrFail($currentMemberId);
        $reader->groups()->detach($currentGroupId);

        session()->flash('message', 'Retrait réussie');
        $this->emit('closeModal');

        $this->resetPage();
    }

    public function paginationView()
    {
        return 'livewire.pagination';
    }


    public function render()
    {
        if(Auth::user()->role==="Bibliothécaire")
        {
            $readers = User::user()->whereDoesntHave('groups', function ($query) {
                $query->where('groups.id', $this->group->id);
            })->WhereDoesntHave('group', function ($query) {
                $query->where('id', $this->group->id);
            })->where([['role', '<>', 'Administrateur'], ['role', '<>', 'Bibliothécaire']])
            ->orderByDesc('lastname')
            ->get();
        }

        $members = User::where(function($query) {
            $query->where('lastname', 'LIKE', '%'.$this->searchInput.'%')
            ->orWhere('firstname', 'LIKE', '%'.$this->searchInput.'%');
        })->where('role', '<>' ,'Bibliothécaire')
           ->where('role', '<>' ,'Administrateur')
            ->whereHas('groups', function($query) {
                $query->where('groups.id', $this->group->id);
                })->orderByDesc('id')->paginate(10);


        return view('livewire.member', [
            'readers' => $readers ?? null,
            'members' => $members,
        ]);
    }
}
