<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resource extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'identification_number',
        'registration_number',
        'title',
        'authors',
        'publication_year',
        'cover_page',
        'digital_version',
        'copies_number',
        'page_number',
        'available_number',
        'edition',
        'type_id',
        'sub_category_id',
        'institute_id',
        'keywords'
    ];

    /**
     * Get the category of resource.
     */
    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class);
    }

    /**
     * Get the type of resource.
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * Get the institute of resource.
     */
    public function institute()
    {
        return $this->belongsTo(Institute::class);
    }

    /**
     * The reservations that belong to the resource.
     */
    public function reservations()
    {
        return $this->belongsToMany(Reservation::class);
    }

    /**
     * The loans that belong to the resource.
     */
    public function loans()
    {
        return $this->belongsToMany(Loan::class);
    }

    public function scopeResource(Builder $query)
    {
        $user = User::find(Auth::user()->id);

        if($user->role === "Bibliothécaire")
        {
            $query->where('institute_id', $user->institute()->first()->id);
        }
        else
        {
            $query;
        }
    }
}
