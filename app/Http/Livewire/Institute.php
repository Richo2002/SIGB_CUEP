<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Institute as ModelsInstitute;

class Institute extends Component
{
    use withPagination;

    public $searchInput;
    public $institutesLength;

    protected $institutes;

    public function updatedSearchInput()
    {
        $this->institutes = Institute::where('name', 'LIKE', '%'.$this->searchInput.'%')
                                    ->orWhere('address', 'LIKE', '%'.$this->searchInput.'%')
                                    ->orWhereHas('librarian', function($query) {
                                        $query->where('firstname', 'LIKE', '%'.$this->searchInput.'%')
                                        ->orWhere('lastname', 'LIKE', '%'.$this->searchInput.'%');
                                        })->orderByDesc('id')->paginate(10);
    }

    public function delete(int $currentInstituteId)
    {
        $institute = ModelsInstitute::findOrFail($currentInstituteId);
        $institute->delete();

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
        if(!$this->searchInput)
        {
            $this->institutes = ModelsInstitute::orderByDesc('id')->paginate(10);
            $this->institutesLength = $this->institutes->total();

        }
        return view('livewire.institute', [
            'institutes' => $this->institutes
        ]);
    }
}
