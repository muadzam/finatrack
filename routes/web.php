<?php

use App\Http\Controllers\TrackerController;
use Illuminate\Support\Facades\Route;

Route::get('/',[TrackerController::class,'dashboard'])->name('dashboard');

Route::get('income',[TrackerController::class,'incomeForm'])->name('incomeForm');
Route::post('income',[TrackerController::class,'storeIncome'])->name('storeIncome');

Route::get('expense',[TrackerController::class,'expenseForm'])->name('expenseForm');
Route::post('expense',[TrackerController::class,'storeExpense'])->name('storeExpense');

Route::get('saving',[TrackerController::class,'savingForm'])->name('savingForm');
Route::post('saving',[TrackerController::class,'storeSaving'])->name('storeSaving');
