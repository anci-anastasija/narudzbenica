<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Resources\SupplierResource;
use App\Http\Resources\SupplierCollection;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::all();
        if($suppliers->count()>0){
            return new SupplierCollection($suppliers);
        }
        else{
            return response()->json([
                'status'=>404,
                'orders'=>'No suppliers found'
            ],404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'supplier_name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors'=>$validator->messages()
            ],422);
        }
        else{
            $supplier = Supplier::create([
            'supplier_name' => $request->supplier_name,
            'country' => $request->country,
            ]);
            if($supplier){
                return response()->json([
                    'status'=>200,
                    'message'=>'Supplier added.'
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

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return new SupplierResource($supplier);
    }

    /**
     * Show the form for editing the specified resource.
     */


     public function edit($id)
    {
        $supplier = Supplier::find($id);
        if($supplier){
            return response()->json([
                'supplier' => $supplier
            ]);
        }
        else{
            return response()->json([
                'message' => 'Supplier not found'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'supplier_name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        $supplier = Supplier::find($id);
        if($supplier){
            $supplier->update([
                'supplier_name' => $request->supplier_name,
                'country' => $request->country,
            ]);

            $supplier->save();
            return response()->json([
            'message'=>'Supplier updated.',
            'supplier'=>$supplier
        ]);
        }
        else{
            return response()->json([
                'message' => 'Supplier not found'
            ]);
        }
    }
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return response()->json([
            'message' => 'Supplier deleted'
        ]);
    }
}
