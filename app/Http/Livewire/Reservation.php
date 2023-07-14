<?php

namespace App\Http\Livewire;

use App\Models\Reservation as ModelsReservation;
use Livewire\Component;
use Livewire\WithPagination;

class Reservation extends Component
{
    use WithPagination;

    public $searchInput = '';
    public $resources = [];
    public $reservationsLength;

    public function mount()
    {
        $this->reservationsLength = ModelsReservation::reservation()->count();
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
        $reservations = ModelsReservation::reservation()->where(function($query) {
            $query->where('start_date', 'LIKE', '%'.$this->searchInput.'%')
            ->orWhere('end_date', 'LIKE', '%'.$this->searchInput.'%')
            ->orWhereHas('reader', function($query) {
                $query->where('lastname', 'LIKE', '%'.$this->searchInput.'%')
                ->orWhere('firstname', 'LIKE', '%'.$this->searchInput.'%');
            });
        })->orderByDesc('id')->paginate(10);

        return view('livewire.reservation', [
            'reservations' => $reservations
        ]);
    }
}
