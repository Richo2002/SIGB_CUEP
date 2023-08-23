<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubSubCategoryRequest;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\SubSubCategory;

class SubSubCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('librarian');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('resources-sub-sub-categories');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(int $subCategoryId)
    {
        $sub_category = SubCategory::findOrFail(intval($subCategoryId));
        return view('add-resources-sub-sub-category', [
            'sub_category' => $sub_category,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubSubCategoryRequest $request, $subCategoryId)
    {
        SubCategory::findOrFail($subCategoryId);

        SubSubCategory::create([
            'name' => $request->name,
            'classification_number' => $request->classification_number,
            'sub_category_id' => intval($subCategoryId),
        ]);

        return redirect()->route('sub-sub-categories.index')->with(['message' => 'Enregistrement réussi']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sub_sub_category = SubSubCategory::findOrFail($id);

        return view('add-resources-sub-sub-category', [
            'sub_sub_category' => $sub_sub_category,
            'sub_category' => $sub_sub_category->sub_category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubSubCategoryRequest $request, $id)
    {
        $sub_sub_category = SubSubCategory::findOrFail($id);

        $sub_sub_category->name = $request->name;
        $sub_sub_category->classification_number = $request->classification_number;
        $sub_sub_category->sub_category_id = $sub_sub_category->sub_category->id;
        $sub_sub_category->save();

        return redirect()->route('sub-sub-categories.index');
    }
}
