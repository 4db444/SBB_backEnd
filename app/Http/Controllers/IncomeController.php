<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Income;
use App\Models\IncomeCategory;
use Throwable;

class IncomeController extends Controller
{
    public function index (){
        try{
            $user = Auth::user();
            $incomes = $user->incomes;
    
            return response()->json($incomes);
        }catch(Throwable $e){
            return response()->json([
                "message" => "something went wrong !",
                "error" => $e->getMessage()
            ]);
        }
    }

    public function store (Request $request){
        try{
            $validated_income = $request->validate([
                "amount" => "required|numeric|min:0|",
                "description" => "nullable|string|max:1000",
                "category" => "nullable|string|max:255",
            ]);

            $user = Auth::user();
            $category = null;

            if(!empty($validated_income["category"])){
                $category = IncomeCategory::where(["name" => $validated_income["category"]])->first();
            }

            $income = Income::create($validated_income);

            if($category) $income->category()->associate($category);
            $income->user()->associate($user);
            $income->save();

            return response()->json(["message" => "income created successfully !"]);
        }catch(Throwable $e){
            return response()->json([
                "message" => "something just went wrong !",
                "error" => $e->getMessage()
            ]);
        }
    }

    public function show ($id){
        try{
            $user = Auth::user();
            $income = $user->incomes()->where("id", $id)->firstOrFail();

            return response()->json($income);
        }catch (Throwable $e){
            return response()->json(['message' => "oops! looks like something went wrong !"]);
        }
    }

    public function destroy($id){

    }
}
