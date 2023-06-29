<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

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
