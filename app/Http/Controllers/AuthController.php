<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Throwable;

class AuthController extends Controller
{
    public function store (Request $request){
        try{
            $credentials = $request->validate([
                "first_name" => ["required", "regex:/^[a-z]{2,}(\s[a-z]{2,})?$/i"],
                "last_name" => ["required", "regex:/^[a-z]{2,}(\s[a-z]{2,})?$/i"],
                "password" => ['required','confirmed','min:8', "regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/"],
                "email" => "required|email|unique:users",
            ]);

            // this will handle the default profiel pic ;)

            $credentials['password'] = Hash::make($credentials["password"]);
            
            $user = User::create($credentials);

            return response()->json(["message" => "registred successfully"], 201);
        }catch (Throwable $e){
            return response()->json(["message" => "error something just happened !", "err" => $e->getMessage()]);
        }
    }
    
    public function login (Request $request) {
        try{
            $credentials = $request->only(["email", "password"]);
            
            if(Auth::attempt($credentials)){
                return response()->json(["msg" => "logged in successfully"]);
            }
            
            return response()->json(["msg" => "wrong credentials !"]);
        }catch(Throwable $e){
            return response()->json(["message" => "error something just happened !", "err" => $e->getMessage()]);
        }
    }

    public function show (Request $request){
        $user = Auth::user();
        return response()->json($user);
    }

    public function destroy (Request $request){
        Auth::guard("web")->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return response()->json(["msg" => "logged out successfully !"], 200);
    }
}
