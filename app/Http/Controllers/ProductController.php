<?php

namespace App\Http\Controllers;

use Debugbar;
use App\Product;
use App\Thematic;
use Illuminate\Support\Arr;
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
        $product = Product::where('id', '=', $request->id)->first();
        if ($product) {
            return new ProductResource($product);
        } else {
            return response()->json(['message' => 'Product not found', 'statusCode' => $this->notFoundStatus], $this->notFoundStatus);
        }
    }

    public function getRelatedProducts(Request $request) {
        $arrayOfProductsIdWithoutInput = Product::whereHas('thematics', function($query) use($request) {
            $query->where('slug', '=', $request->thematicSlug);
        })->where('id', '!=', $request->id)->pluck('id')->toArray();
        return ProductResource::collection(Product::find(Arr::random($arrayOfProductsIdWithoutInput, 3)));
    }

}
