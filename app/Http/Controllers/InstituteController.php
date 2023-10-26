<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstituteRequest;
use App\Models\Institute;
use App\Models\User;
use Illuminate\Http\Request;

class InstituteController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $institutes = Institute::orderByDesc('id')->get();

        return view('institutes', [
            'institutes' => $institutes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $librarians_actif_without_institute = User::leftJoin('institutes', 'users.id', '=', 'institutes.librarian_id')
                    ->whereNull('institutes.librarian_id')
                    ->where([['users.role', 'Bibliothécaire'], ['users.status', true]])
                    ->select('users.id', 'users.lastname', 'users.firstname')
                    ->orderBy('users.lastname')
                    ->get();

        return view('add-institute', [
            'librarians' => $librarians_actif_without_institute,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InstituteRequest $request)
    {
        $librarian = User::find(intval($request->librarian_id));

        if(!$librarian)
        {
            return back()->withErrors('librarian_id', 'Veuillez selectionner un bibliothécaire');
        }

        $institute = Institute::create([
            'name' => $request->name,
            'address' => $request->address,
            'librarian_id' => $librarian->id,
        ]);

        return redirect()->route('institutes.index')->with(['message' => 'Enrégistrement réussi']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $institute = Institute::with('user')->findOrFail($id);

        $current_librarian_and_librarians_actif_without_institute = User::leftJoin('institutes', 'users.id', '=', 'institutes.librarian_id')
                    ->select('users.id', 'users.lastname', 'users.firstname')
                    ->whereNull('institutes.librarian_id')
                    ->where([['users.role', 'Bibliothécaire'], ['users.status', true]])
                    ->orWhere('users.id', $institute->user->id)
                    ->get();

        return view('add-institute', [
            'institute' => $institute,
            'librarians' => $current_librarian_and_librarians_actif_without_institute,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InstituteRequest $request, $id)
    {
        $institute = Institute::findOrFail($id);

        $institute->name = $request->name;
        $institute->address = $request->address;

        $institute->librarian_id = intval($request->librarian_id);

        $institute->save();

        return redirect()->route('institutes.index')->with(['message' => 'Mis à jour réussie']);
    }
}
