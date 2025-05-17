<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post("/register", [AuthController::class, "store"])->middleware("auth:guest");
Route::post("/login", [AuthController::class, "login"])->middleware("auth:guest");
Route::get("/user", [AuthController::class, "show"])->middleware("auth:sanctum");