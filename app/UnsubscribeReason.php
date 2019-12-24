<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnsubscribeReason extends Model
{
    protected $table = 'unsubscribe_reasons';
    public $timestamps = true;
    protected $fillable = ['name','valid' ];

    protected $attributes = [
        'valid' => true
    ];

}
