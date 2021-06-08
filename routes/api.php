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
Route::domain("192.168.137.11")->post("/post-wireless", [DataController::class, 'store']);
Route::domain("169.254.229.223")->post("/post-wired", [DataController::class, 'store']);
