<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'responsable_id'
    ];

    /**
     * Get the responsable of the group.
     */
    public function responsable()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The readers that belong to the group.
     */
    public function readers()
    {
        return $this->belongsToMany(User::class, 'group_user', 'group_id', 'reader_id');
    }

    /**
     * Get the loans for the group.
     */
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }






}
