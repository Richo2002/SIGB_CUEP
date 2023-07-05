<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategory extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'classification_number',
        'category_id'
    ];


    /**
     * Get the resources for the Category.
     */
    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    /**
     * Get the category of resource.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
