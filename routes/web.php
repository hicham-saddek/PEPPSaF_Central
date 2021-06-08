<?php

use App\Http\Controllers\DataController;
use App\Http\Controllers\CalculatedDataController;
use App\Http\Controllers\NotCalculatedDataController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::domain("192.168.137.11")->group(function(){
	Route::get("/all", [DataController::class, 'all']);
	Route::get("/unseen", [DataController::class, 'unseen']);
	Route::get("/seen", [DataController::class, 'seen']);
	Route::get("/delete", [DataController::class, 'destroy']);

	Route::prefix("calculated")->group(function(){
		Route::get("/unseen", [CalculatedDataController::class, "unseen"]);
		Route::get("/seen", [CalculatedDataController::class, "seen"]);
		Route::get("/all", [CalculatedDataController::class, "all"]);
	});

	Route::prefix("not-calculated")->group(function(){
		Route::get("/unseen", [NotCalculatedDataController::class, "unseen"]);
		Route::get("/seen", [NotCalculatedDataController::class, "seen"]);
		Route::get("/all", [NotCalculatedDataController::class, "all"]);
	});
});
