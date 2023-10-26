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
     * Get the resources for the Sub Category.
     */
    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    /**
     * Get the resources through the Sub Sub Category.
     */
    public function resourcesThroughSubSubCategories()
    {
        return $this->hasManyThrough(Resource::class, SubSubCategory::class);
    }

    /**
     * Get the Sub Sub Categoies for the Sub Category.
     */
    public function sub_sub_categories()
    {
        return $this->hasMany(SubSubCategory::class);
    }

    /**
     * Get the category of resource.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
