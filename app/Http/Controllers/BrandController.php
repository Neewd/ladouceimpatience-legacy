<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(Request $request) 
    {           
        $result = new \stdClass();
        $brands = Brand::all();

        return response()->json(['brands' => $brands]);
    }

}
