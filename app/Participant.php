<?php

namespace App;

use DateTime;
use Debugbar;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $table = 'participant';
    public $timestamps = true;
    protected $fillable = ['email','firstname', 'lastname', 'birth_date', 'unsubscribe_reason' ];

    protected $dates = [
        'created_at',
        'updated_at',
        'birth_date',
    ];

    protected $hidden = [ 'unsubscribe_token' ];

    public function setBirthDateAttribute($value)
    {
        $date = DateTime::createFromFormat("d-m-Y", $value);
        $this->attributes['birth_date'] = $date;
    }

    public function getBirthDateAttribute($value)
    {
        return (new Carbon($value))->format('d-m-Y');
    }

}
