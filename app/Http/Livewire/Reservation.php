<?php

namespace App\Http\Livewire;

use App\Models\Reservation as ModelsReservation;
use Livewire\Component;
use Livewire\WithPagination;

class Reservation extends Component
{
    use WithPagination;

    public $searchInput;
    public $resources = [];
    public $reservationsLength;


    protected $reservations;

    public function paginationView()
    {
        return 'livewire.pagination';
    }

    public function updatedSearchInput()
    {
        $this->reservations = ModelsReservation::reservation()->where('start_date', 'LIKE', '%'.$this->searchInput.'%')
                            ->where('start_date', 'LIKE', '%'.$this->searchInput.'%')
                            ->orWhereHas('reader', function($query) {
                                $query->where('lastname', 'LIKE', '%'.$this->searchInput.'%')
                                ->orWhere('firstname', 'LIKE', '%'.$this->searchInput.'%');
                            })->paginate(10);
    }

    public function getReservedResources($currentReservationId)
    {
        $reservation = ModelsReservation::findOrFail($currentReservationId);
        $this->resources = $reservation->resources;
    }

    public function lend(int $currentReservationId)
    {

        $reservation = ModelsReservation::findOrFail($currentReservationId);

        $resourceIds = $reservation->resources->pluck('id')->toArray();
        session(['selections' => $resourceIds, 'reader_npi' => $reservation->reader->npi]);
        return redirect()->route('loans.create');
    }

    public function render()
    {
        if(!$this->searchInput)
        {
            $this->reservations = ModelsReservation::reservation()->paginate(10);
            $this->reservationsLength = $this->reservations->total();

        }

        return view('livewire.reservation', [
            'reservations' => $this->reservations
        ]);
    }
}
