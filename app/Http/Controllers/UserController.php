<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Password;
use App\Notifications\NewAccountNotification;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        if($request->has('photo'))
        {
            $path = Storage::putFile('public/profiles', $request->photo);
            $path_convert_to_table = explode('/', $path);
        }

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'npi' => $request->npi,
            'registration_number' => $request->registration_number,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'role' => $request->has('role') ? $request->role : 'Bibliothécaire',
            'password' => Hash::make(Str::random(8)),
            'photo' => $request->has('photo') ? $path_convert_to_table[2] : null,
        ]);

        dd($user, $request->registration_number);

        $status = Password::sendResetLink(
            $request->only('email'),
            function ($message) use($user) {
                $message->notify(new NewAccountNotification($user));
            }
        );

         if($status == Password::RESET_LINK_SENT)
         {
            return $user;
         }
         else
         {
            $last_user = User::where('email', $request->email)->first();

            if($last_user)
            {
                $last_user->delete();
            }
            return back()->withInput($request->only('email'))->withErrors(['email' => __($status)]);
         }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($request, $user)
    {
        if($request->has('photo'))
        {
            if(Storage::exists('public/profiles/'.$user->photo))
            {
                Storage::delete('public/profiles/'.$user->photo);
            }

            $path = Storage::putFile('public/profiles', $request->photo);
            $path_convert_to_table = explode('/', $path);

            $user->photo = $path_convert_to_table[2];
        }

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->npi = $request->npi;
        $user->registration_number = $request->registration_number;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->address = $request->address;

        $user->save();
    }
}
