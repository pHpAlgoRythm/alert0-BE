<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RequestController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\SystemPhotoController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\HistoryController;

// authenctication
Route::controller(RegisterController::class)->group(function(){
    Route::post('PendingAccounts', 'PendingAccounts');
    Route::post('register', 'Register');
    Route::post('login', 'login');
    Route::post('approvePendingUser/{id}', 'approvePendingUser');
    Route::get('getResidents','getResidents');
    Route::get('retrieveDriver', 'retrieveDriver');
    Route::get('retrieveResponder', 'retrieveResponder');
    Route::get('getPendingUsers', 'getPendingUsers');
    Route::get('getSpecificUser/{id}', 'getSpecificUser');
    Route::delete('declinePendingUser/{id}', 'declinePendingUser');
    Route::put('updatePersonalInfo/{id}', 'updatePersonalInfo');

    

});

//emergency response requesting
Route::apiResource('requests', RequestController::class);

//profile picture
Route::middleware('auth:sanctum')->group(function(){
    Route::post('/profile/uploadProfile', [ProfileController::class, 'updateProfilePicture']);
    Route::get('/profile/displayProfile',[ProfileController::class, 'retrieveProfilePicture']);
});

//system photo
Route::controller(SystemPhotoController::class)->group(function(){
        Route::post('storeSystemPhoto', 'storeSystemPhoto');
        Route::put('updateSystemPhoto',  'updateSystemPhoto');
        Route::get('displaySystemPhoto', 'displaySystemPhoto');
});

// send response
Route::controller(ResponseController::class)->group(function(){
    Route::post('storeResponse', 'storeResponse');
    Route::put('updateStatus/{id}', 'updateStatus');
    Route::put('updateResponderResponse/{id}', 'updateResponderResponse');
    Route::put('updateDriverResponse/{id}', 'updateDriverResponse');
    Route::put('updateLocation/{id}', 'updateResponseLocation');
    Route::get('displayAssignment', 'displayAssignment');
});

Route::controller(HistoryController::class)->group(function(){
    Route::get('displayHistory', 'showAllHistory');
    Route::post('createNewHistory', 'createHistory');
});