<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Librarian extends Component
{
    use WithPagination;

    public $searchInput = '';
    public $librariansLength;

    public function mount()
    {
        $this->librariansLength = User::where('role', '=' ,'Bibliothécaire')->count();
    }

    public function updating($name, $value)
    {
        if($name === 'searchInput')
        {
            $this->resetPage();
        }
    }

    public function paginationView()
    {
        return 'livewire.pagination';
    }

    public function render()
    {
        $librarians = User::where('role', '=' ,'Bibliothécaire')
            ->where('email', 'like', '%'. $this->searchInput. '%')
            ->orWhere('phone_number', 'like', '%'.$this->searchInput.'%')
            ->orWhere('lastname', 'like', '%'.$this->searchInput.'%')
            ->orWhere('firstname', 'like', '%'.$this->searchInput.'%')
            ->orWhereHas('institute', function($subQuery) {
                $subQuery->where('name', 'like', '%'.$this->searchInput.'%')
                ->orWhere('address', 'like', '%'.$this->searchInput.'%');
                })->orderByDesc('id')->paginate(10);

        return view('livewire.librarian', [
            'librarians' => $librarians
        ]);
    }
}
