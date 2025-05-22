<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\GroupController;


Route::middleware("auth:sanctum")->group(function(){
    Route::prefix("/auth")->group(function (){
        Route::get("/user", [AuthController::class, "show"])->middleware("auth:sanctum");
        Route::post("/logout", [AuthController::class, "destroy"])->middleware("auth:sanctum"); 
    });

    Route::prefix("/income")->group(function(){
        Route::get("/", [IncomeController::class, "index"]);
        Route::post("/", [IncomeController::class, "store"]);
        Route::put("/{id}", [IncomeController::class, "update"]);
        Route::delete("/{id}", [IncomeController::class, "destroy"]);
    });
    
    Route::prefix("/expense")->group(function(){
        Route::get("/", [ExpenseController::class, "index"]);
        Route::post("/", [ExpenseController::class, "store"]);
        Route::put("/{id}", [ExpenseController::class, "update"]);
        Route::delete("/{id}", [ExpenseController::class, "destroy"]);
    });

    Route::prefix("/group")->group(function(){
        Route::get("/", [GroupController::class, "index"]);
        Route::post("/", [GroupController::class, "store"]);
        Route::get("/{id}/members", [GroupController::class, "members"]);
        Route::post("/{id}/generate", [GroupController::class, "generate_token"]);
        Route::get("/join/{join_token}", [GroupController::class, "join"]);
    });
    
});

Route::middleware("guest")->group(function (){
    Route::prefix("/auth")->group(function (){
        Route::post("/register", [AuthController::class, "store"]);
        Route::post("/login", [AuthController::class, "login"]);
    });
});
