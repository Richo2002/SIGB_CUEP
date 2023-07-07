<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loan extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'start_date',
        'end_date',
        'status',
        'reader_id',
        'group_id'
    ];


    /**
     * Get the user that make the loan.
     */
    public function reader()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Get the group that make the loan.
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * The resources that belong to the loan.
     */
    public function resources()
    {
        return $this->belongsToMany(Resource::class);
    }

    public function scopeLoan(Builder $query)
    {
        $user = User::find(Auth::user()->id);

        if($user->role === "Bibliothécaire")
        {
            $query->whereHas('resources', function($query) use($user) {
                $query->where('resources.institute_id', $user->institute()->first()->id);
            })->orderByRaw("
                CASE
                    WHEN status = 'Retard' THEN 1
                    WHEN status = 'En cour' THEN 2
                    WHEN status = 'Terminé' THEN 3
                    ELSE 4
                END
            ");
        }
        else
        {
            $query->whereHas('resources', function($subQuery) use($user) {
                $subQuery->where('resources.institute_id', $user->registrations()->latest()->first()->institute_id);
            })->where(function($query) use($user) {
                $query->where('reader_id', $user->id)->orWhereHas('group', function($subQuery) use ($user) {
                    $subQuery->where('responsable_id', $user->id)
                    ->orWhereHas('readers', function($subSubQuery) use ($user) {
                        $subSubQuery->where('users.id', $user->id);
                    });
                });
            })->orderByRaw("
                CASE
                    WHEN status = 'Retard' THEN 1
                    WHEN status = 'En cour' THEN 2
                    WHEN status = 'Terminé' THEN 3
                    ELSE 4
                END
            ");
        }
    }

}
