<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        if($products->count()>0){
            return new ProductCollection($products);
        }
        else{
            return response()->json([
                'status'=>404,
                'products'=>'No products found'
            ],404);
        }
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'brand' => 'required|string|max:255',
            'product_type' => 'required|string|max:255',
            'model' => 'required|string|max:255',
        ]);
        if($validator->fails()){
            return response()->json([
                'starus' => 422,
                'errors'=>$validator->messages()
            ],422);
        }
        else{
            $product = Product::create([
            'brand' => $request->brand,
            'product_type' => $request->product_type,
            'model' => $request->model,
            ]);
            if($product){
                return response()->json([
                    'status'=>200,
                    'message'=>'Product added.'
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
        $product = Product::find($id);
        if($product){

            return response()->json([
                'product' => $product
            ]);
        }
        else{
            return response()->json([
                'message' => 'Product not found'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'brand' => 'required|string|max:255',
            'product_type' => 'required|string|max:255',
            'model' => 'required|string|max:255',
        ]);

        $product = Product::find($id);
        if($product){
            $product->update([
                'brand' => $request->brand,
                'product_type' => $request->product_type,
                'model' => $request->model,
            ]);

            $product->save();
            return response()->json([
            'message'=>'Product updated.',
            'product'=>$product
        ]);
        }
        else{
            return response()->json([
                'message' => 'Product not found'
            ]);
        }
    }
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([
            'message' => 'Product deleted'
        ]);
    }
}
