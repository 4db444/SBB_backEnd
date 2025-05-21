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
                "amount" => "required|numeric|min:0",
                "description" => "nullable|string|max:1000",
                "category" => "nullable|string|max:255",
            ]);

            $user = Auth::user();
            
            $income = new Income($validated_income);
            $income->user()->associate($user);

            if(!empty($validated_income["category"])){
                $category = IncomeCategory::where(["name" => $validated_income["category"]])->first();
                if($category) $income->category()->associate($category);
            }

            $income->save();

            return response()->json(["message" => "income created successfully !"]);
        }catch(Throwable $e){
            return response()->json([
                "message" => "something just went wrong !",
                "error" => $e->getMessage()
            ]);
        }
    }

    public function destroy ($id){
        try{
            $user = Auth::user();
            $income = $user->incomes()->where("id", $id)->firstOrFail();
            $income->delete();

            return response()->json(["message" => "income deleted successfully !"]);
        }catch(Throwable $e){
            return response()->json([
                "message" => "somthing just happened !",
                "error" => $e->getMessage()
            ]);
        }
    }

    public function update (Request $request, $id){
        try{
            $validated_income = $request->validate([
                "amount" => "required|min:0|numeric",
                "description" => "nullable|string|max:1000",
                "category" => "nullable|string|max:255"
            ]);
            
            $user = Auth::user();
            
            $income = $user->incomes()->where("id", $id)->firstOrFail();
            $income->update($validated_income);
            
            if(!empty($validated_income["category"])) {
                $category = IncomeCategory::where(["name" => $validated_income["category"]])->first();
                $income->category()->associate($category);
            }else{
                $income->category()->dissociate();
            }

            $income->save();
            return response()->json(['message' => "income updated successfully !"]);
        }catch(Throwable $e){
            return response()->json([
                "message" => "something happened !",
                "error" => $e->getMessage()
            ]);
        }
    }
}
