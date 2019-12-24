<?php

namespace App;

use DateTime;
use Debugbar;
use Carbon\Carbon;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password', 'gender', 'phone', 'birth_date', 'resend_token'
    ];

    public $timestamps = true;

    protected $attributes = [
        'is_admin' => false,
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'birth_date',
    ];

    public function setBirthDateAttribute($value)
    {
        $date = DateTime::createFromFormat("d/m/Y", $value);
        $this->attributes['birth_date'] = $date;
    }

    public function getBirthDateAttribute($value)
    {
        return (new Carbon($value))->format('d-m-Y');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'resend_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
