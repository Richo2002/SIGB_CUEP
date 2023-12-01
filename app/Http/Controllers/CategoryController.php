<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
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
        return view('resources-categories');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('update-resources-category', [
            'category' =>$category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($id ?? null)],
            'classification_number' => ['required', 'regex:/^[0-9]+$/', Rule::unique('categories')->ignore($id ?? null)],
        ]);

        $category = Category::findOrFail($id);

        $category->name = $request->name;
        $category->classification_number = $request->classification_number;
        $category->save();

        return redirect()->route('categories.index')->with(['message' => 'Mis à jour réussie']);
    }

}
