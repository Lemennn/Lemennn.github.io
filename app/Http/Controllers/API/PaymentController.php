<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function send(Request $request){
        
    }
    public function payment_handler(Request $request){
        $json = json_decode($request->getContent());

        $signature_key = hash('sha512', $json->order_id . $json->status_code . $json->gross_amount . 'SB-Mid-server-0IWJQ6jfCGLO59iBlYphsfbR');
        
        if($signature_key != $request->signature_key){
            return abort(404);
        }
        
        return $json;
    }
}
