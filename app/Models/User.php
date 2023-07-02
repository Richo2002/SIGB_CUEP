<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
            'firstname',
            'lastname',
            'npi',
            'email',
            'phone_number',
            'address',
            'role',
            'password',
            'photo'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the institute that librarian manage.
     */
    public function institute()
    {
        return $this->hasOne(Institute::class, 'librarian_id');
    }

    /**
     * Get the registrations for the user.
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class, 'reader_id');
    }

    /**
     * Get the registrations for the user.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'reader_id');
    }

    /**
     * Get the groups for the reader.
    */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_user', 'reader_id');
    }

    /**
     * Get the group for the responsable.
     */
    public function group()
    {
        return $this->hasOne(Group::class, 'responsable_id');
    }


    /**
     * Get the loans for the user.
     */
    public function loans()
    {
        return $this->hasMany(Loan::class, 'reader_id');
    }

    public function scopeUser(Builder $query)
    {
        $user = User::find(Auth::user()->id);

        $query->whereHas('registrations', function($query) use($user){
            $query->where('registrations.institute_id', $user->institute()->first()->id);
        });
    }
}
