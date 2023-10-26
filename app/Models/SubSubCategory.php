<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubSubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'classification_number',
        'sub_category_id'
    ];

    /**
     * Get the resources for the Sub Sub Category.
     */
    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    /**
     * Get the sub_category of Sub Sub Category.
     */
    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
