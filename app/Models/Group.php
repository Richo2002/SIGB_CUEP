<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'responsable_id',
        'institute_id'
    ];

    /**
     * Get the responsable of the group.
     */
    public function responsable()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the institute of the group.
     */
    public function institute()
    {
        return $this->belongsTo(Institute::class);
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

    public function scopeGroup(Builder $query)
    {
        $user = User::find(Auth::user()->id);

        if($user->role === "Bibliothécaire")
        {
            $query->where('institute_id', $user->institute()->first()->id);
        }
        else
        {
            $query->where('institute_id', $user->registrations()->latest()->first()->institute_id);
        }
    }






}
