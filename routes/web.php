<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResponsavelController;

use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');


Route::resource(
    'responsaveis',
    ResponsavelController::class
);
