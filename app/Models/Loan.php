<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

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

}
