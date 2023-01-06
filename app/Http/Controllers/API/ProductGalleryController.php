<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductGallery;
use Illuminate\Http\Request;

class ProductGalleryController extends Controller
{
    public function fetch(Request $request){
        $id = $request->input('id');
        $url = $request->input('url');

        if($id){
            $data = ProductGallery::with('product')->find($id);
            if($data){
                return response()->json(
                    ['status' => 200, 'massage' => 'Success Fetch', 'data' => $data],
                    200
                );
            }else{
                return response()->json(
                    ['status' => 500, 'message' => 'Failed Fetch'],
                    500
                );
            }
        }

        $data = ProductGallery::with('product')->get();

        if($url){
            $data->where('name', 'Like', '%'. $data . '%');
        }

        return response()->json(
            ['status' => 200, 'message' => 'Success Fetch', 'data' => $data],
            200
        );
    }
}
