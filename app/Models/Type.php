<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * Get the resources for the Type.
     */
    public function resources()
    {
        return $this->hasMany(Resource::class);
    }
}
