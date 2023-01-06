<?php

namespace App\Http\Controllers\API;

use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Exception;

class FeedbackController extends Controller
{
    public function sendfeedback(Request $request){
        try {
            $request->validate([
                'status' => 'required|in:pending,success,shipping,cancelled,failed'
            ]);

            $data =  Feedback::create([
                'users_id' => Auth::user()->id,
                'review' => $request->status,
            ]);
    
            return response()->json(
                ['status' => 200, 'message' => 'Feedback Sended', 'data' => $data],
                200
            );
        } catch (Exception $err) {
            throw $err;
        }

    }

    public function fetch(Request $request){
        $id = $request->input('id');
        $name = $request->input('users_id');

        $data = Feedback::with('user')->get();
        if($id){
            $data->find($id);
            if($data){
                return response()->json(
                    ['code' => 200, 'message' => 'Success Fetch', 'data' => $data],
                    200
                );
            }else{
                return response()->json(
                    ['code' => 500, 'message' => 'Failed Fetch'],
                    500
                );
            }

            if($name){
                $data->where('users_id', $name);
            }

            return response()->json(
                ['code' => 200, 'message' => 'Success Fetch', 'data' => $data],
                200
            );
        }
    }

}
