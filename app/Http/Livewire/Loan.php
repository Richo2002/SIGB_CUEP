<?php

namespace App\Http\Livewire;

use App\Models\Loan as ModelsLoan;
use Livewire\Component;
use Livewire\WithPagination;

class Loan extends Component
{
    use withPagination;

    public $searchInput;
    public $loansLength;


    protected $loans;
    public $resources = [];

    public function paginationView()
    {
        return 'livewire.pagination';
    }

    public function updatedSearchInput()
    {
        $this->loans = ModelsLoan::loan()->where('start_date', 'LIKE', '%'.$this->searchInput.'%')
                            ->where('start_date', 'LIKE', '%'.$this->searchInput.'%')
                            ->orWhereHas('reader', function($query) {
                                $query->where('lastname', 'LIKE', '%'.$this->searchInput.'%')
                                ->orWhere('firstname', 'LIKE', '%'.$this->searchInput.'%');
                            })->paginate(10);
    }

    public function getLoanedResources($currentLoanId)
    {
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
        if(!$this->searchInput)
        {
            $this->loans = ModelsLoan::loan()->paginate(10);
            $this->loansLength = $this->loans->total();
        }

        return view('livewire.loan', [
            'loans' => $this->loans
        ]);
    }

}
