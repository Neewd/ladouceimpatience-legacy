<?php

namespace App\Http\Controllers;

use Debugbar;
use App\Product;
use App\Thematic;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    
    public function index(Request $request) 
    {           
        $result = new \stdClass();
        $products = Product::whereHas('thematics', function($query) use($request) {
            $query->where('slug', '=', $request->thematic);
        })->get();

        $result->products = ProductResource::collection($products);
        $result->thematic = Thematic::where('slug', '=', $request->thematic)->first();
        return \json_encode($result);
    }

    public function getDetails(Request $request) {
        return ProductResource::collection(Product::where('id', '=', $request->id)->get());
    }

}
