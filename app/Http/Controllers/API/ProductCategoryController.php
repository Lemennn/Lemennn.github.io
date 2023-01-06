<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function fetch(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');

        if ($id) {
            $data = ProductCategory::with('product')->find($id);
            if ($data) {
                return response()->json(
                    ['status' => 200, 'message' => 'Success Fetch', 'data' => $data,],
                    200
                );
            }else{
                return response()->json(
                    ['status' => 500 , 'message' => 'Failed Fetch'],
                    500
                );
            }
        }

        $data = ProductCategory::with('product')->get();
        
        if($name){
            $data->where('name', 'Like', '%' . $name . '%');
        }

        return response()->json(
            ['status' => 200, 'message' => 'Success Fetch', 'data' => $data],
            200
        );
    }
}
