<?php

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
Route::get('login', [Auth\LoginController::class, 'showLoginForm'])->name('login');
use App\Http\Controllers\CertificateRequestController;
use App\Http\Controllers\IncomeController;

Route::resource('certificate-requests', CertificateRequestController::class);



Route::get('/income', [IncomeController::class, 'showIncomeByDate'])->name('income.show');

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
