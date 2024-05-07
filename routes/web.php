<?php

use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile', [ProfileController::class, 'updatephone'])->name('profile.updatephone');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', function () {
    return view('Main');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/device', fn () => view('Device'))->name('device')->middleware('is_user');
    Route::get('/ticket', fn () => view('Ticket'))->name('ticket')->middleware('is_user');
    Route::get('/process', fn () => view('Process'))->name('process')->middleware('process');
    Route::get('/manageuser', fn () => view('ManageUser'))->name('manageuser')->middleware('is_admin');
    Route::get('/weblog', fn () => view('WebLog'))->name('log')->middleware('is_admin');
});

Route::get('/auth/{provider}/redirect', [GoogleAuthController::class, 'redirect']);
Route::get('/auth/{provider}/callback', [GoogleAuthController::class, 'callback']);

Route::get('/', function () {
    // route('dashboard');
    return view('landing-page');
});

Route::get('/sendmailer', function () {
    event(new \App\Events\sendNotification('wahyutricahyono777@gmail.com', 'suradin', 'suradinlothok@gmail.com', 'done', \App\Models\Ticket::first()));
});


require __DIR__ . '/auth.php';
