<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Group;
use Throwable;

class ExpenseController extends Controller
{
    public function index (){
        try{
            $user = Auth::user();
            $expenses = $user->expenses;
    
            return response()->json($expenses);
        }catch(Throwable $e){
            return response()->json([
                "message" => "something just happened !",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function store (Request $request){
        try{
            $validated_expense = $request->validate([
                "amount" => "required|numeric|min:0",
                "description" => "nullable|string|max:1000",
                "category" => "nullable|string|max:255", 
                "group" => "nullable", 
            ]);
    
            $user = Auth::user();
    
            $expense = new Expense([
                "amount" => $validated_expense["amount"],
                "description" => $validated_expense["description"],
            ]);
    
            $expense->user()->associate($user);
    
            if(!empty($validated_expense["category"])){
                $category = ExpenseCategory::where(["name" => $validated_expense["category"]])->first();
    
                if($category) $expense->category()->associate($category);
            }
    
            if(!empty($validated_expense["group"])){
                $group = $user->groups()->find($validated_expense["group"]);
    
                if($group) $expense->group()->associate($group);
            }
    
            $expense->save();

            return response()->json([
                "message" => "expense registred successfully !"
            ]);
        }catch(Throwable $e){
            return response()->json([
                "message" => "oops! something just happened !",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function destroy ($id){

        try{
            $user = Auth::user();
            $expense = $user->expenses()->find($id);
            
            if($expense){
                $expense->delete();
                return response()->json([
                    "message" => "expense deleted successfully !"
                ]);
            }

            return response()->json([
                "message" => "expense does not exist !"
            ], 404);
        }catch(Throwable $e){
            return response()->json([
                "message" => "something just happened",
                "error" => $e->getMessage()
            ]);
        }

    }
}
