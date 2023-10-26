<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Registration extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'start_date',
        'end_date',
        'status',
        'reader_id',
        'institute_id'
    ];


    /**
     * Get the user that owns the registration.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the institute that make registration to the reader.
     */
    public function institute()
    {
        return $this->belongsTo(Institute::class);
    }

}
