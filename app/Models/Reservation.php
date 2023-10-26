<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'start_date',
        'end_date',
        'status',
        'reader_id',
        'loan_id'
    ];

    /**
     * Get the user that make the reservation.
     */
    public function reader()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The resources that belong to the reservation.
     */
    public function resources()
    {
        return $this->belongsToMany(Resource::class);
    }

    /**
     * The loan that belong to the reservation.
     */
    public function loan()
    {
        return $this->hasOne(Loan::class);
    }

    public function scopeReservation(Builder $query)
    {
        $user = User::find(Auth::user()->id);

        if($user->role === "Bibliothécaire")
        {
            $query->whereHas('resources', function($query) use($user) {
                $query->where('resources.institute_id', $user->institute()->first()->id);
            });
        }
        else
        {
            $query->whereHas('resources', function($query) use($user) {
                $query->where('resources.institute_id', $user->registrations()->latest()->first()->institute_id);
            })->where('reader_id', $user->id);
        }
    }



}
