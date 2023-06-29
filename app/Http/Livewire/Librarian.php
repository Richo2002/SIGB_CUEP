<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Librarian extends Component
{
    use WithPagination;

    public $searchInput;
    public $librariansLength;


    protected $librarians;

    public function updatedSearchInput()
    {
        $this->librarians = User::where('lastname', 'LIKE', '%'.$this->searchInput.'%')
                                    ->orWhere('firstname', 'LIKE', '%'.$this->searchInput.'%')
                                    ->where('role', '=' ,'Bibliothécaire')
                                    ->whereHas('institute', function($query) {
                                        $query->where('name', 'LIKE', '%'.$this->searchInput.'%')
                                        ->orWhere('address', 'LIKE', '%'.$this->searchInput.'%');
                                        })->orderByDesc('id')->paginate(10);
    }

    public function paginationView()
    {
        return 'livewire.pagination';
    }

    public function render()
    {
        if(!$this->searchInput)
        {
            $this->librarians = User::orderByDesc('id')
                        ->where('role', '=' ,'Bibliothécaire')
                        ->paginate(10);

            $this->librariansLength = $this->librarians->total();

        }

        return view('livewire.librarian', [
            'librarians' => $this->librarians
        ]);
    }
}
