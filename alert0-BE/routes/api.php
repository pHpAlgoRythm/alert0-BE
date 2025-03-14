<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RequestController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ProfileController;

// authenctication
Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::get('retrieveDriver', 'retrieveDriver');
    Route::get('retrieveResponder', 'retrieveResponder');
});

//emergency response requesting
Route::apiResource('requests', RequestController::class);

//profile picture
Route::middleware('auth:sanctum')->group(function(){
    Route::post('/profile/uploadProfile', [ProfileController::class, 'updateProfilePicture']);
    Route::get('/profile/displayProfile',[ProfileController::class, 'retrieveProfilePicture']);
});



