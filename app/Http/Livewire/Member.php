<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Member extends Component
{
    use WithPagination;

    public $group;
    public $reader_id;
    public $membersLength;

    public $searchInput;
    protected $members;


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

    public function updatedSearchInput()
    {
        $this->members = User::where('lastname', 'LIKE', '%'.$this->searchInput.'%')
                                    ->orWhere('firstname', 'LIKE', '%'.$this->searchInput.'%')
                                    ->where('role', '<>' ,'Bibliothécaire')
                                    ->where('role', '<>' ,'Administrateur')
                                    ->whereHas('groups', function($query) {
                                        $query->where('groups.id', $this->group->id);
                                        })->orderByDesc('id')->paginate(10);
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

        $readers = User::whereDoesntHave('groups', function ($query) {
                    $query->where('groups.id', $this->group->id);
                })->WhereDoesntHave('group', function ($query) {
                    $query->where('id', $this->group->id);
                })->where([['role', '<>', 'Administrateur'], ['role', '<>', 'Bibliothécaire']])
                ->get();

        if(!$this->searchInput)
        {
            $this->members = User::whereHas('groups', function($query) {
                $query->where('groups.id', $this->group->id);
            })->paginate(10);

            $this->membersLength = $this->members->total();
        }


        return view('livewire.member', [
            'readers' => $readers,
            'members' => $this->members,
        ]);
    }
}
