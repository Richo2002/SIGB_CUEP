<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'classification_number'
    ];

    /**
     * Get the sub category for the Category.
     */
    public function sub_categories()
    {
        return $this->hasMany(SubCategory::class)->orderBy('name', 'asc');
    }
}
