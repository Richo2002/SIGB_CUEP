<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Institute as ModelsInstitute;

class Institute extends Component
{
    use withPagination;

    public $searchInput = '';
    public $institutesLength;

    public function mount()
    {
        $this->institutesLength = ModelsInstitute::count();
    }

    public function updating($name, $value)
    {
        if($name === 'searchInput')
        {
            $this->resetPage();
        }
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
        $institutes = ModelsInstitute::where('name', 'LIKE', '%'.$this->searchInput.'%')
                                    ->orWhere('address', 'LIKE', '%'.$this->searchInput.'%')
                                    ->orWhereHas('user', function($query) {
                                        $query->where('firstname', 'LIKE', '%'.$this->searchInput.'%')
                                        ->orWhere('lastname', 'LIKE', '%'.$this->searchInput.'%');
                                        })->orderByDesc('id')->paginate(10);

        return view('livewire.institute', [
            'institutes' => $institutes
        ]);
    }
}
