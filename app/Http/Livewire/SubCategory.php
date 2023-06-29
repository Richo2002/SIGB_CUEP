<?php

namespace App\Http\Livewire;

use App\Models\SubCategory as SubDomain;
use Livewire\Component;
use Livewire\WithPagination;

class SubCategory extends Component
{
    use WithPagination;

    public $searchInput;
    public $subCategoriesLength;


    protected $sub_categories;


    public function paginationView()
    {
        return 'livewire.pagination';
    }

    public function updatedSearchInput()
    {
        $this->sub_categories = SubDomain::where('name', 'LIKE', '%'.$this->searchInput.'%')->orderByDesc('id')->paginate(10);
    }

    public function delete(int $currentSubDomainId)
    {
        $sub_category = SubDomain::findOrFail($currentSubDomainId);
        $sub_category->delete();

        session()->flash('message', 'Suppression réussie');
        $this->emit('closeModal');

        $this->resetPage();
    }

    public function render()
    {
        if(!$this->searchInput)
        {
            $this->sub_categories = SubDomain::orderByDesc('id')->paginate(10);
            $this->subCategoriesLength = $this->sub_categories->total();
        }

        return view('livewire.sub-category', [
            'sub_categories' => $this->sub_categories
        ]);
    }
}
