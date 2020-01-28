<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "product";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'available_stock', 'unit_price', 'brand_id'
    ];

    public $timestamps = true;

    protected $attributes = [
        'available_stock' => 0,
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function thematics() {
        return $this->belongsToMany(Thematic::class, 'products_thematics')->withTimestamps();
    }

    public function primaryThematic() {
        return $this->belongsToMany(Thematic::class,  'products_thematics')->wherePivot('primary', true);
    }

    public function brand() {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function images() {
        return $this->hasMany(ProductImage::class);
    }

    public function labels() {
        return $this->belongsToMany(Label::class, 'products_labels')->withTimestamps();
    }

}
