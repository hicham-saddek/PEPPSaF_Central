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
Route::post("/post-wired", [DataController::class, 'store'])->domain("wired.central.peppsaf");
Route::post("/post-wireless", [DataController::class, 'store'])->domain("wireless.central.peppsaf");
