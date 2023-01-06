<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductGallery;
use Exception;

class ProductController extends Controller
{
    public function fetch(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $category = $request->input('categories');
        $description = $request->input('description');
        $price_from = $request->input('price_from');
        $price_to = $request->input('price_to');

        
        if ($id) {
            $product = Product::with(['category', 'galleries'])->find($id);
            if ($product) {
                return [
                    'data' => $product,
                    'Success Fetch Data',
                ];
            } else {
                return [
                    'Data not found',
                ];
            }
        }
        
        $product = Product::with(['category', 'galleries'])->get();
        
        if ($name) {
            $product->where('name', 'Like',  '%' . $name . '%');
        }
        if ($category) {
            $product->where('categories', 'Like',  '%' . $category . '%');
        }
        if ($description) {
            $product->where('description', 'Like',  '%' . $description . '%');
        }
        if ($price_from) {
            $product->where('price_from', '=>', $price_from);
        }
        if ($price_to) {
            $product->where('price_to', '=>', $price_to);
        }
        return response()->json(
            ['status' => 200 ,'message' => 'Data Success Fetch', 'data' => $product],
            200,
        );
    }

}
