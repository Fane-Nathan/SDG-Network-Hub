<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OpportunityController;
use Illuminate\Support\Facades\Route;

Route::get('/', [OpportunityController::class, 'publicIndex'])->name('home');
Route::get('/opportunities/{opportunity:slug}', [OpportunityController::class, 'show'])->name('opportunities.show');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/opportunities', [OpportunityController::class, 'manage'])->name('opportunities.manage');
    Route::get('/dashboard/opportunities/create', [OpportunityController::class, 'create'])->name('opportunities.create');
    Route::post('/dashboard/opportunities', [OpportunityController::class, 'store'])->name('opportunities.store');
    Route::get('/dashboard/opportunities/{opportunity:slug}/edit', [OpportunityController::class, 'edit'])->name('opportunities.edit');
    Route::put('/dashboard/opportunities/{opportunity:slug}', [OpportunityController::class, 'update'])->name('opportunities.update');
    Route::delete('/dashboard/opportunities/{opportunity:slug}', [OpportunityController::class, 'destroy'])->name('opportunities.destroy');

    Route::post('/opportunities/{opportunity:slug}/apply', [ApplicationController::class, 'store'])->name('applications.store');
    Route::get('/dashboard/applications', [ApplicationController::class, 'index'])->name('applications.mine');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});