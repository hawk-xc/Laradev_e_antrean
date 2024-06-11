<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\apis\{

    AuthApisController,
    TicketApisController,
    ProfileApisController
};

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/login', [AuthApisController::class, 'login']);
Route::post('/register', [AuthApisController::class, 'register']);

// Route::resource('/profile', [ProfileApisController::class])->middleware('auth:sanctum');
// Route::resource('/profile', [AuthApisController::class])->middleware('auth:sanctum');

Route::get('/antrean', [TicketApisController::class, 'index'])->middleware('auth:sanctum');
