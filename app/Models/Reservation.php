<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

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



}
