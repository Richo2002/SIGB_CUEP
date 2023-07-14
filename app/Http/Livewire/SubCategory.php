<?php

namespace App\Http\Livewire;

use App\Models\SubCategory as SubDomain;
use Livewire\Component;
use Livewire\WithPagination;

class SubCategory extends Component
{
    use WithPagination;

    public $searchInput = '';
    public $subCategoriesLength;

    public function mount()
    {
        $this->subCategoriesLength = SubDomain::count();

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
        $sub_categories = SubDomain::where('name', 'LIKE', '%'.$this->searchInput.'%')->orderByDesc('id')->paginate(10);

        return view('livewire.sub-category', [
            'sub_categories' => $sub_categories
        ]);
    }
}
