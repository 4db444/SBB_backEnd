<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IncomeController;


Route::middleware("auth:sanctum")->group(function(){
    Route::prefix("/income")->group(function(){
        Route::get("/{id}", [IncomeController::class, "show"]);
        Route::post("/", [IncomeController::class, "store"]);
        Route::put("/{id}", [IncomeController::class, "update"]);
        Route::delete("/{id}", [IncomeController::class, "destroy"]);
    });
    
    Route::prefix("/auth")->group(function (){
        Route::get("/user", [AuthController::class, "show"])->middleware("auth:sanctum");
        Route::post("/logout", [AuthController::class, "destroy"])->middleware("auth:sanctum"); 
    });
});

Route::middleware("guest")->group(function (){
    Route::prefix("/auth")->group(function (){
        Route::post("/register", [AuthController::class, "store"])->middleware("guest");
        Route::post("/login", [AuthController::class, "login"])->middleware("guest");
    });
});
