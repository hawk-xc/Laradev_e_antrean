<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\apis\{

    AuthApisController,
    DeviceApisController,
    DevicesApisController,
    ProcessApisController,
    TicketApisController,
    ProfileApisController
};
use App\Http\Controllers\apis\DevicesApiController;
use App\Http\Controllers\DevicesApiController as ControllersDevicesApiController;

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
// Route::resource('/devices', [DevicesApiController::class])->middleware('auth:sanctum');
Route::apiResource('/devices', DevicesApisController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
])->middleware('auth:sanctum');
Route::apiResource('/proces', ProcessApisController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
])->middleware('auth:sanctum');
// Route::apiResource('/devices', DevicesApiController::class)->only([
//     // 'index', 'show', 'update', 'destroy'
// ]);
Route::get('/device', [DeviceApisController::class, 'index'])->middleware('auth:sanctum');
Route::post('/device', [DeviceApisController::class, 'store'])->middleware('auth:sanctum');
Route::put('/device/{id}', [DeviceApisController::class, 'show'])->middleware('auth:sanctum');
Route::post('/device/{id}', [DeviceApisController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/device/{id}', [DeviceApisController::class, 'destroy'])->middleware('auth:sanctum');
