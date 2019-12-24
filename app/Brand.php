<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = "brand";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'picture_url'
    ];

    public $timestamps = true;

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function products() {
        return $this->hasMany(Product::class);
    }
}
