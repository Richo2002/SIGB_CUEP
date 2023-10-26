<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Institute;
use Illuminate\Support\Str;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LibrarianRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Password;
use App\Notifications\NewAccountNotification;

class LibrarianController extends Controller
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
        $librarians = User::where('role', 'Bibliothécaire')->orderByDesc('id')->get();
        return view('librarians', [
            'librarians' => $librarians,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('add-librarian');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LibrarianRequest $request)
    {
        app('App\Http\Controllers\UserController')->store($request);

        return redirect()->route('librarians.index')->with(['message' => 'Enregistrement réussi']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $librarian = User::where([['role', 'Bibliothécaire'], ['id', $id]])
                    ->firstOrFail();

        return view('add-librarian', [
            'librarian' => $librarian
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LibrarianRequest $request, $id)
    {

        $librarian = User::where([['role', 'Bibliothécaire'], ['id', $id]])
                    ->firstOrFail();

        app('App\Http\Controllers\UserController')->update($request, $librarian);

        return redirect()->route('librarians.index')->with(['message' => 'Mis à jour réussie']);
    }
}
