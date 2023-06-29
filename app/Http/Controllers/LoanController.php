<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\User;
use App\Models\Group;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Requests\LoanRequest;

class LoanController extends Controller
{
    public function __construct()
    {
        $this->middleware('librarian')->except(['index']);
        $this->middleware('librarianOrReader')->only(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('loans');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(session()->has('selections'))
        {
            return view('add-loan', [
                'selections' => session('selections')
            ]);
        }
        else  abort(403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoanRequest $request)
    {
        if($request->has('group_id'))
        {
            $loaner = Group::where('id', intval($request->group_id))->first();
        }
        else
        {
            $loaner = User::where([['role', '<>' ,'Administrateur'], ['role', '<>' ,'Bibliothécaire'], ['npi', intval($request->npi)]])->first();
        }
        $start_date = Carbon::now();

        $loan = new Loan([
            'start_date' => $start_date,
            'end_date' => $request->end_date,
            'status' => "En cour",
        ]);

        $loaner->loans()->save($loan);

        $loan->resources()->attach(session('selections'));

        session()->forget('selections');

        if(session()->has('reader_npi'))
        {
            session()->forget('reader_npi');
            $reservation = Reservation::orderByDesc('id')->where('reader_id', $loaner->id)->first();

            $reservation->status = "Terminé";
            $reservation->loan_id = $loan->id;

            $reservation->save();
        }

        return redirect()->route('loans.index')->with(['message' => 'Enregistrement réussi']);
    }
}
