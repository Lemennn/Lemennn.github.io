<?php

namespace App\Http\Controllers\API;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DetailTransaction;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function fetch(Request $request){
        $id = $request->input('id');
        $status = $request->input('status');

        if($id){
            $data = Transaction::with(['items.product'])->where('users_id', Auth::user()->id);
            if($data){
                return response()->json(
                    ['status' => 200, 'message' => 'Success Fetch', 'data' => $data],
                    200
                );
            }else{
                return response()->json(
                    ['status' => 500 , 'message' => 'Failed Fetch' ],
                    500
                );
            }
        }

        $data = Transaction::with(['items.product'])->get();
        if($status){
            $data->where('status', $data);
        }

        return response()->json(
            ['code' => 200, 'message' => 'Success Fetch', 'data' => $data],
            200
        );
    }

    public function checkout(Request $request) {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-0IWJQ6jfCGLO59iBlYphsfbR';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
        try {
            $validator = Validator::make($request->all(),[
                'items' => 'required|array',
                'admin_location' => 'required',
                'items.*.id' => 'exists:products,id',
                'status' => 'required|in:pending,success,shipping,cancelled,failed',
                'total_price' => 'required',
                'shipping_price' => 'required',
                'payment' => 'required'
            ]);
            if($validator->fails()){
                return response()->json($validator->errors(), 400);
            }

            foreach($request->items as $data) {
                $param = array(
                    'transaction_details' => array(
                        'order_id' => rand(),
                        'gross_amount' => $request->total_price
                    ),
                    'item_details' => array(
                        'id' => $data->id,
                        'price' => $data->price,
                        'name' => $data->name
                    ),
                    'customer_details' => array(
                        'first_name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                        'phone' => Auth::user()->phone
                    ),
                );
            }

            $transaction = Transaction::create([
                'users_id' => Auth::user()->id,
                'status' => $request->status,
                'admin_location' => $request->admin_location,
                'total_price' => $request->total_price,
                'shipping_price' =>$request->shipping_price,
                'payment' =>$request->payment
            ]);

            foreach($request->items as $product){
                DetailTransaction::create([
                    'users_id' => Auth::user()->id,
                    'products_id' => $product['id'],
                    'transactions_id' => $transaction->id,
                    'quantity' => $product['quantity'] 
                ]);
            }

            $snaptoken = \Midtrans\Snap::getSnapToken($param);

            return response()->json(
                ['status' => 200, 'message' => 'Transaction Succcess', 'data' => $transaction->load('items.product'), 'midtrans' => $snaptoken]
            );
        } catch (Exception $err) {
            return response()->json(
                ['code' => 500, 'message' => 'Failed Validation' ,  'error_message' => $err->getLine()],
                500
            );
        }
    }
    
    public function updateProduct(Request $request){
        try {
            $request->validate([    
                'transaction_id' => 'required',
                'status' => 'required|string'
            ]);
            
            $data = Transaction::with(['items.product'])->where('transaction_id', $request->transaction_id )->get();
            
            $data->status = $request->status;
            $data->save();
            
            return response()->json(
                ['code' => 200, 'message' => 'Data Updated', 'data'=> $data->load(['items.product'])],
                200
            );
        } catch (Exception $err) {
           throw $err;
        }
    }

    public function fetch_payment(Request $request){
        $json = json_decode($request->getContent());

        $signature_key = hash('sha512', $json->order_id . $json->status_code . $json->gross_amount . 'SB-Mid-server-0IWJQ6jfCGLO59iBlYphsfbR');
        
        if($signature_key != $request->signature_key){
            return abort(404);
        }
        
        return $json;
    }
}
