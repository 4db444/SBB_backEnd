<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthController extends Controller
{
    public function store (Request $request){
        try{
            $credentials = $request->validate([
                "first_name" => ["required", "regex:/^[a-z]{2,}(\s[a-z]{2,})?$/i"],
                "last_name" => ["required", "regex:/^[a-z]{2,}(\s[a-z]{2,})?$/i"],
                "password" => "required|confirmed|min:8",
                "email" => "required|email|unique:users",
            ]);

            // this will handle the default profiel pic ;)

            $credentials['password'] = Hash::make($credentials["password"]);
            
            $user = User::create($credentials);

            return response()->json(["message" => "registred successfully"]);
        }catch (Throwable $e){
            return response()->json(["message" => "error something just happened !", "err" => $e->getMessage()]);
        }
    }
}
