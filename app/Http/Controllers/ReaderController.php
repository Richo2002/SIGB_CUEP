<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Http\Requests\ReaderRequest;
use App\Models\Institute;
use Illuminate\Support\Facades\Auth;

class ReaderController extends Controller
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
        return view('readers');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('add-reader');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReaderRequest $request)
    {
        $user = app('App\Http\Controllers\UserController')->store($request);

        $start_date = Carbon::now()->format('Y-m-d');
        $end_date = Carbon::now()->addYear()->format('Y-m-d');
        $institute = Institute::where('librarian_id', Auth::user()->id)->first();

        Registration::create([
            'start_date' => $start_date,
            'end_date' => $end_date,
            'reader_id' => $user->id,
            'institute_id' => $institute->id,
        ]);

        return redirect()->route('readers.index')->with(['message' => 'Enregistrement réussi']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reader = User::where([['role', '<>' ,'Administrateur'], ['role', '<>' ,'Bibliothécaire'], ['id', $id]])
                    ->firstOrFail();

        $this->authorize('view', $reader);

        return view('add-reader', [
            'reader' => $reader
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReaderRequest $request, $id)
    {
        $reader = User::where([['role', '<>' ,'Bibliothécaire'], ['role', '<>' ,'Administrateur'] ,['id', $id]])
                    ->firstOrFail();

        $this->authorize('update', $reader);


        app('App\Http\Controllers\UserController')->update($request, $reader);

        return redirect()->route('readers.index')->with(['message' => 'Mis à jour réussie']);
    }

    public function disableReader()
    {
        $today = Carbon::today();

        $readers = User::where('role', '<>' ,'Administrateur')
                        ->where('role', '<>' ,'Bibliothécaire')
                        ->where('status','true')
                        ->whereHas('registrations', function($query) use($today){
                            $query->where('end_date', '<', $today)
                            ->orderByDesc('id')
                            ->limit(1);
                        })->get();

        foreach ($readers as $reader) {
            $reader->update(['status' => false]);
        }
    }
}
