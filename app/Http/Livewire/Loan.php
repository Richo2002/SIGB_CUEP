<?php

namespace App\Http\Livewire;

use App\Models\Loan as ModelsLoan;
use Livewire\Component;
use Livewire\WithPagination;

class Loan extends Component
{
    use withPagination;

    public $searchInput = '';
    public $loansLength;

    public $resources = [];

    public function mount()
    {
        $this->loansLength = ModelsLoan::count();
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

    public function getLoanedResources($currentLoanId)
    {
        sleep(1);
        $loan = ModelsLoan::findOrFail($currentLoanId);
        $this->resources = $loan->resources;
    }

    public function retrieve($currentLoanId)
    {
        $loan = ModelsLoan::findOrFail($currentLoanId);

        $loan->resources()->increment('available_number');

        $loan->status = "Terminé";
        $loan->save();

        session()->flash('message', 'Les ressources ont été récupérés avec succès');

        $this->emit('closeModal');

        $this->resetPage();
    }

    public function render()
    {
        $loans = ModelsLoan::loan()->where(function($query) {
            $query->where('start_date', 'LIKE', '%'.$this->searchInput.'%')
            ->orWhere('end_date', 'LIKE', '%'.$this->searchInput.'%')
            ->orWhereHas('reader', function($query) {
                $query->where('lastname', 'LIKE', '%'.$this->searchInput.'%')
                ->orWhere('firstname', 'LIKE', '%'.$this->searchInput.'%');
            });
        })->orderByDesc('id')->paginate(10);

        return view('livewire.loan', [
            'loans' => $loans
        ]);
    }

}
