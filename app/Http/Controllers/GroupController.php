<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Group;

class GroupController extends Controller
{
    public function index (){
        try{
            $user = Auth::user();
            $groups = $user->groups->load("members");

            $groups->each(function ($group) {
                if ($group->pivot) {
                    unset($group->pivot->user_id, $group->pivot->group_id);
                }
                $group->members->each(function ($member) {
                    if ($member->pivot) {
                        unset($member->pivot);
                    }
                });
            });
    
            return response()->json($groups);
        }catch(Throwable $e){
            return response()->json([
                "error" => $e->getMessage()
            ]);
        }
    }

    public function store (Request $request){
        try{
            $validated_request = $request->validate([
                "name" => "required|string|max:225"
            ]);
    
            $user = Auth::user();

            if($user->groups()->where(["name" => $validated_request["name"]])->exists()){
                return response()->json([
                    "error" => "deplicate name for group : ". $validated_request["name"]
                ], 409);
            };
    
            $group = Group::create([
                "name" => $validated_request["name"]
            ]);
    
            $user->groups()->attach($group, ['is_admin' => true]);
    
            return response()->json([
                'message' => 'the group created succussfully !'
            ]);
        }catch(Throwable $e){
            return response()->json([
                "message" => "somehting just happened !",
                "error" => $e->getMessge()
            ]);
        }
    }
}
