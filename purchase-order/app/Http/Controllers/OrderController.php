<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderCollection;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        //return OrderResource::collection($orders);
        return new OrderCollection($orders);
    }

    public function show(Order $order)
    {
        return new OrderResource($order);
    }
}
