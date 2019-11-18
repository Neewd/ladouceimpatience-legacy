<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thematic extends Model 
{

    protected $table = 'thematic';
    public $timestamps = true;
    protected $fillable = ['name','order', 'slug'];


    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

}