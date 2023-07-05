<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Resource;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('librarian')->except(['index', 'create', 'store']);
        $this->middleware('librarianOrReader')->only(['index', 'create', 'store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reservations');
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
            $resources = Resource::whereIn('id', session('selections'))->get();

            $start_date = Carbon::today();
            $end_date = $start_date->copy()->addDays(3);

            return view('add-reservation', [
                'resources' => $resources,
                'start_date'  => $start_date,
                'end_date' => $end_date,
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
    public function store(Request $request)
    {
        $start_date = Carbon::today();
        $end_date = $start_date->copy()->addDays(3);

        $reader = User::where([['role', '<>' ,'Administrateur'], ['role', '<>' ,'Bibliothécaire']])->find(Auth::user()->id);

        $reservation = new Reservation([
            'start_date' => $start_date,
            'end_date' => $end_date,
            'status' => "En cour",
        ]);

        $reader->reservations()->save($reservation);

        $reservation->resources()->attach(session('selections'));

        foreach (session('selections') as $id) {

            $resource = Resource::find($id);

            if ($resource) {

                $resource->available_number -= 1;

                $resource->save();
            }
        }

        session()->forget('selections');

        return redirect()->route('reservations.index')->with(['message' => 'Enregistrement réussi']);
    }

    public function manageDelays()
    {
        $today = Carbon::today();
        $reservations = Reservation::where('end_date', '<', $today)
                ->where('status', 'En cour')
                ->get();

        foreach ($reservations as $reservation) {
            $reservation->update(['status' => "Expiré"]);
        }

        dd($reservations);
    }
}
