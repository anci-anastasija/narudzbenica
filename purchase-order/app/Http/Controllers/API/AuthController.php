<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'employee_name'=>'required|string|max:255',
            'email'=>'required|string|max:255|email|unique:users',
            'password'=>'required|string|min:8'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }
        $user = User::create([
            'employee_name'=>$request->employee_name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),

        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['data'=>$user, 'access_token'=>$token, 'token_type'=>'Bearer']);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'=> 'email|required',  
            'password'=> 'required' 
        ]); 

        $credentials = request(['email','password']);
        if(!auth()->attempt($credentials)){
            return response()->json([
                'message'=>'Invalid data',
            ]);
        }
        $user = User::where('email',$request->email)->first();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token'=>$token,
        ]);

    }
    public function logout(Request $request) {

        auth()->user()->tokens()->delete();
        return response()->json([
            'message'=>'User logged out',
        ]);
    }   
}