<?php

namespace App\Http\Livewire;

use App\Models\Group;
use Livewire\Component;

class AddLoanForm extends Component
{
    public $loaner = "Group";

    public function showForm($loaner)
    {
        $this->loaner = $loaner;
    }

    public function render()
    {
        $groups = [];

        if($this->loaner == "Group")
        {
            $groups = Group::whereHas('responsable', function($query) {
                $query->where('status', true);
            })->get();
        }

        return view('livewire.add-loan-form', [
            'groups' => $groups
        ]);
    }
}
