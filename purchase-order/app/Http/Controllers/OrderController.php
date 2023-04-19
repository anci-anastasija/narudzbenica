<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{   
    
    public function index()
    {
        $orders = Order::all();
        if($orders->count()>0){
            return new OrderCollection($orders);
        }
        else{
            return response()->json([
                'status'=>404,
                'orders'=>'No records found'
            ],404);
        }
    }
       

    public function show(Order $order)
    {   
        if(Auth::user()->id !== $order->user_id){
           
            return response()->json([
                'error'=>'You are not authorized to make this request'
            ]);
        }
        else{
            return new OrderResource($order);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'order_description' => 'required|string|max:255',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
            'supplier_id' => 'required|integer',
        ]);
        if($validator->fails()){
            return response()->json([
                'starus' => 422,
                'errors'=>$validator->messages()
            ],422);
        }
        else{
            $order = Order::create([
            'order_description' => $request->order_description,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'supplier_id' => $request->supplier_id,
            'user_id' => Auth::user()->id,
            ]);
            if($order){
                return response()->json([
                    'status'=>200,
                    'message'=>'Order added.'
                ]);
            }
            else{
                return response()->json([
                    'status'=>500,
                    'message'=>'Something went wrong'
                ],500);
            }
        }
    }
    public function edit($id)
    {

    

        $order = Order::find($id);
        if($order){
            if(Auth::user()->id !== $order->user_id){
           
                return response()->json([
                    'error'=>'You are not authorized to make this request'
                ]);
            }
            return response()->json([
                'order' => $order
            ]);
        }
        else{
            return response()->json([
                'message' => 'Data not found'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'order_description' => 'required|string|max:255',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
            'supplier_id' => 'required|integer',
        ]);

        $order = Order::find($id);
        if($order){
            if(Auth::user()->id !== $order->user_id){
           
                return response()->json([
                    'error'=>'You are not authorized to make this request'
                ]);
            }
            /*
            $order->order_description =  $request->get('order_description');
            $order->product_id = $request->get('product_id');
            $order->quantity = $request->get('quantity');
            $order->supplier_id = $request->get('supplier_id');
            $order->update(['updated_at' => now()->format('Y-m-d H:i:s')]);
            */
            $order->update([
            'order_description' => $request->order_description,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'supplier_id' => $request->supplier_id,
            'user_id' => Auth::user()->id,
            ]);

            $order->save();
            return response()->json([
            'message'=>'Order updated.',
            'order'=>$order
        ]);
        }
        else{
            return response()->json([
                'message' => 'Data not found'
            ]);
        }
    }
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json([
            'message' => 'Record deleted'
        ]);
    }
}
