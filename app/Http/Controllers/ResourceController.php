<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Models\Author;
use App\Models\Category;
use App\Models\Resource;
use App\Models\Institute;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ResourceRequest;
use Illuminate\Support\Facades\Storage;

class ResourceController extends Controller
{
    public function __construct()
    {
        $this->middleware('librarian')->except(['index', 'edit', 'indexTypes', 'indexCategorySubCategories', 'show', 'download']);
        $this->middleware('librarianOrReader')->only(['index', 'edit']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('resources');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::orderBy('name')->get();

        return view('add-resource',[
            'types' => $types,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResourceRequest $request)
    {
        Type::findOrFail(intval($request->type_id));
        SubCategory::findOrFail(intval($request->sub_category_id));
        $institute = Institute::where('librarian_id', Auth::user()->id)->firstOrFail();

        $path_image = Storage::putFile('public/coverPages', $request->cover_page);
        $path_image_convert_to_table = explode('/', $path_image);

        if($request->has('digital_version'))
        {
            $path_digital_version = Storage::putFile('public/digitalVersions', $request->digital_version);
            $path_digital_version_convert_to_table = explode('/', $path_digital_version);
        }

        $resource = Resource::create([
            'identification_number' => $request->identification_number,
            'registration_number' => $request->registration_number,
            'title' => $request->title,
            'cover_page' => $path_image_convert_to_table[2],
            'digital_version' => $request->has('digital_version') ? $path_digital_version_convert_to_table[2] : null,
            'page_number' => $request->page_number,
            'copies_number' => $request->copies_number,
            'available_number' => $request->copies_number,
            'edition' => $request->edition,
            'ray' => $request->ray,
            'type_id' => $request->type_id,
            'sub_category_id' => $request->sub_category_id,
            'authors' => $request->authors,
            'institute_id' => $institute->id,
            'keywords' => $request->keywords,
        ]);

        return redirect()->route('resources.index')->with(['message' => 'Enregistrement réussi']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $types = Type::orderBy('name')->get();

        $resource = Resource::with(['type', 'sub_category'])->findOrFail($id);

        $this->authorize('view', $resource);

        return view('add-resource', [
            'resource' => $resource,
            'types' => $types,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ResourceRequest $request, $id)
    {
        Type::findOrFail(intval($request->type_id));
        SubCategory::findOrFail(intval($request->sub_category_id));

        $resource = Resource::findOrFail($id);

        $this->authorize('update', $resource);

        if($request->has('cover_page'))
        {
            if(Storage::exists('public/coverPages/'.$resource->cover_page))
            {
                Storage::delete('public/coverPages/'.$resource->cover_page);
            }

            $path_image = Storage::putFile('public/coverPages', $request->cover_page);
            $path_image_convert_to_table = explode('/', $path_image);

            $resource->cover_page = $path_image_convert_to_table[2];
        }

        if($request->has('digital_version'))
        {
            if(Storage::exists('public/digitalVersions/'.$resource->digital_version))
            {
                Storage::delete('public/digitalVersions/'.$resource->digital_version);
            }

            $path_digital_version = Storage::putFile('public/digitalVersions', $request->digital_version);
            $path_digital_version_convert_to_table = explode('/', $path_digital_version);

            $resource->digital_version = $path_digital_version_convert_to_table[2];
        }

        if($resource->copies_number != $request->copies_number)
        {
            $nbr_difference = $resource->copies_number - $request->copies_number;
            $resource->available_number = $nbr_difference;
        }

        $resource->identification_number = $request->identification_number;
        $resource->registration_number = $request->registration_number;
        $resource->title = $request->title;
        $resource->copies_number = $request->copies_number;
        $resource->page_number = $request->page_number;
        $resource->edition = $request->edition;
        $resource->ray = $request->ray;
        $resource->edition = $request->edition;
        $resource->type_id = $request->type_id;
        $resource->sub_category_id = $request->sub_category_id;
        $resource->authors = $request->authors;
        $resource->keywords = $request->keywords;

        $resource->save();

        return redirect()->route('resources.index')->with(['message' => 'Mis à jour réussie']);
    }

    public function indexTypes($id)
    {
        $type = Type::findOrFail($id);
        $type_name = $type->pluck('name')->first();

        return view('typeOrSubCategoryResources', [
            'type_name' => $type_name,
            'id' => $id,
            'column' => 'type_id',
        ]);
    }

    public function indexCategorySubCategories($id)
    {
        $subCategory = SubCategory::findOrFail($id);

        return view('typeOrSubCategoryResources', [
            'subCategory' => $subCategory,
            'id' => $id,
            'column' => 'sub_category_id',
        ]);
    }

    public function show($id)
    {
        return view('showResource', [
            'id' => $id,
        ]);
    }

    public function download($digitalVersion)
    {
         return Storage::download('public/digitalVersions/'.$digitalVersion);
    }
}
