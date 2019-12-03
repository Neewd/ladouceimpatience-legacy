<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $table = 'participant';
    public $timestamps = true;
    protected $fillable = ['email','firstname', 'lastname', 'birth_date' ];

    protected $dates = [
        'created_at',
        'updated_at',
        'birth_date',
    ];

    public function newsletter()
    {
        return $this->belongsToMany('\App\Newsletter');
    }
}
