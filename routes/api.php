<?php

use App\Http\Controllers\DataController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::domain("54.37.6.200")->group(function(){
	Route::post("/post-wired", [DataController::class, 'store']);
	Route::post("/post-wireless", [DataController::class, 'store']);
});
