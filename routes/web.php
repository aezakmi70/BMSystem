<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\OfficialController;
use App\Http\Controllers\CertificateRequestController;
use App\Models\CertificateRequest;
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


Route::get('/print/certificate/{id}', [CertificateRequest::class, 'generatePdf'])->name('print.certificate');

Route::resource('certificate-requests', CertificateRequestController::class);

Route::resource('certificate-requests', OfficialController::class);


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
