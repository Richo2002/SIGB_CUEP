<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Institute extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'address',
        'librarian_id'
    ];


    /**
     * Get the  user associated with the institute.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'librarian_id');
    }

    /**
     * Get the registrations for the institute.
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Get the resources for the institute.
     */
    public function resources()
    {
        return $this->hasMany(Resource::class);
    }


    /**
     * Get the groups created by the institute.
    */
    public function groups()
    {
        return $this->hasMany(Group::class);
    }
}
