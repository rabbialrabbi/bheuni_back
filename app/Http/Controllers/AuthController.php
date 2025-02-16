<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){

        try {
            $loginUserData = $request->validate([
                'email'=>'required|string|email',
                'password'=>'required|min:8'
            ]);
            $user = User::where('email',$loginUserData['email'])->first();
            if(!$user || !Hash::check($loginUserData['password'],$user->password)){
                return response()->json([
                    'message' => 'Invalid Credentials'
                ],401);
            }
            return AuthResource::make($user);

        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Login Failed',
                'error' => $e->getMessage()
            ], 500);
        }

    }

    public function logout(){

        auth()->user()->tokens()->delete();
        return response()->json([
            "message"=>"logged out"
        ]);
    }


}
