<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SubSubCategory as SubSubDomain;

class SubSubCategory extends Component
{
    use WithPagination;

    public $searchInput = '';
    public $subSubCategoriesLength;

    public function mount()
    {
        $this->subSubCategoriesLength = SubSubDomain::count();

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

    public function delete(int $currentSubSubDomainId)
    {
        $sub_sub_category = SubSubDomain::findOrFail($currentSubSubDomainId);
        $sub_sub_category->delete();

        session()->flash('message', 'Suppression réussie');
        $this->emit('closeModal');

        $this->resetPage();
    }

    public function render()
    {
        dd("oklm");
        $sub_sub_categories = SubSubDomain::where('name', 'LIKE', '%'.$this->searchInput.'%')->orderByDesc('id')->paginate(10);

        return view('livewire.sub-sub-category', [
            'sub_sub_categories' => $sub_sub_categories
        ]);
    }
}
