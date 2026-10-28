<?php

use App\Http\Controllers\NexaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [NexaController::class, 'home'])->name('home');
Route::get('/demo', [NexaController::class, 'demo'])->name('demo');
Route::post('/masuk', [NexaController::class, 'login'])->name('login');
Route::post('/keluar', [NexaController::class, 'logout'])->name('logout');
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [NexaController::class, 'dashboard'])->name('dashboard');
    Route::get('/aktivitas', [NexaController::class, 'activity'])->name('activity');
    Route::get('/transfer', [NexaController::class, 'transferPage'])->name('transfer.page');
    Route::get('/profil', [NexaController::class, 'profile'])->name('profile');
    Route::post('/rekening-tujuan', [NexaController::class, 'storeBeneficiary'])->name('beneficiaries.store');
    Route::delete('/rekening-tujuan/{beneficiary}', [NexaController::class, 'destroyBeneficiary'])->name('beneficiaries.destroy');
    Route::post('/transfer', [NexaController::class, 'transfer'])->name('transfer');
});
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [NexaController::class, 'admin'])->name('admin');
});
