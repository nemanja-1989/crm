<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdvisorController;
use App\Http\Middleware\LoanMiddleware;


Route::get('/', function () {
    return view('welcome');
});

//LOGIN 
Route::get('/login', [LoginController::class, 'index'])->name('login-page');
Route::post('login', [LoginController::class, 'authenticate'])->name('login');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

// ADVISOR MAIN PAGE
Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [AdvisorController::class, 'index'])->name('dashboard');
    //CLIENTS
    Route::get('clients', [AdvisorController::class, 'clients'])->name('clients');
    Route::get('create-client', [AdvisorController::class, 'createClient'])->name('createClient');
    Route::get('edit-client/{client}', [AdvisorController::class, 'editClient'])->name('editClient');
    Route::post('store-client', [AdvisorController::class, 'storeClient'])->name('storeClient');
    Route::patch('update-client/{client}', [AdvisorController::class, 'updateClient'])->name('updateClient');
    Route::delete('delete-client/{client}', [AdvisorController::class, 'deleteClient'])->name('deleteClient');
    
    Route::patch('cash-loan-update/{client}', [AdvisorController::class, 'updateCashLoan'])->name('updateCashLoan');
    Route::patch('home-loan-update/{client}', [AdvisorController::class, 'updateHomeLoan'])->name('updateHomeLoan');
    Route::get('reset-loans/{client}', [AdvisorController::class, 'resetLoans'])->name('resetLoans');
    
    Route::get('reports', [AdvisorController::class, 'reports'])->name('reports');
    Route::get('reports-export', [AdvisorController::class, 'reportsExport'])->name('reportsExport');

});



