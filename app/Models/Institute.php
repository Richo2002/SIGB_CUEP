<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        // 'description',
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
}
