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
            $expenses = $user->expenses
                ->load("category");
    
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
                "members" => "nullable|array"
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

                if(!empty($validated_expense['members'])){
                    $expense->save();
                    $group = $user->groups()->find($validated_expense["group"]);
                    $ids = $validated_expense['members'];

                    $member_part = $validated_expense['amount'] / count($ids);

                    foreach($ids as $id){
                        $member = $group->members->find($id);
                        $member->groupExpenseShares()->attach($expense, ["amount" => $member_part]);
                    }
                    
                    if($group) $expense->group()->associate($group);
                }else{
                    return response()->json(["error" => "no members specified !"], 400);
                }
            }
    
            $expense->save();

            return response()->json($expense);
        }catch(Throwable $e){
            return response()->json([
                "message" => "oops! something just happened !",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function update (Request $request, $id){
        try{
            $validated_expense = $request->validate([
                "amount" => "required|numeric|min:0",
                "description" => "nullable|string|max:1000",
                "group" => "nullable",
                "category" => "nullable|string|max:255",
            ]);

            $user = Auth::user();
            $expense = $user->expenses()->findOrFail($id);

            $expense->update([
                "amount" => $validated_expense["amount"],
                "description" => $validated_expense["description"]
            ]);

            if(!empty($validated_expense["group"])){
                $group = $user->groups()->findOrFail($validated_expense['group']);

                $expense->group()->associate($group);
            }else{
                $expense->group()->dissociate();
            }

            if(!empty($validated_expense["category"])){
                $category = ExpenseCategory::where(["name" => $validated_expense["category"]])->firstOrFail();

                $expense->category()->associate($category);
            }else{
                $expense->category()->dissociate();
            }

            $expense->save();

            return response()->json([
                "message" => "expense updated successfully !"
            ]);
        }catch(Throwable $e){
            return response()->json([
                "message" => "something just happened !",
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

    public function categories (){
        try{
            $expenseCategories = ExpenseCategory::where("id_parent_category", null)->get();

            $expenseCategories->load("children");

            return response()->json($expenseCategories);
        }catch (Throwable $e){
            return response()->json([
                "error" => $e->getMessage()
            ]);
        }
    }
}
