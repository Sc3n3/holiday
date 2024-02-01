<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CountryController;
use App\Http\Controllers\HolidayController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/countries', [CountryController::class, 'index']);

Route::prefix('/holidays')->group(function () {
    Route::get('/', [HolidayController::class, 'index']);
    Route::post('/', [HolidayController::class, 'store']);
    Route::put('/{holiday}', [HolidayController::class, 'update']);
    Route::delete('/{holiday}', [HolidayController::class, 'destroy']);
    Route::get('/search', [HolidayController::class, 'search']);
});
