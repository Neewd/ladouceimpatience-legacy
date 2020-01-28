<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $table = "label";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'url_icon'
    ];

    public $timestamps = true;

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function products() {
        return $this->belongsToMany(Product::class, 'products_labels')->withTimestamps();
    }

}
