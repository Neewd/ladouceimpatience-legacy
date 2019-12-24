<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = "products_images";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url', 'product_id', 'type'
    ];

    public $timestamps = true;

    protected $attributes = [
        'type' => 'normal',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

}
