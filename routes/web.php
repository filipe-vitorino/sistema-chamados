<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResponsavelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChamadoController;


Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');


Route::resource(
    'responsaveis',
    ResponsavelController::class
);

Route::resource('chamados', ChamadoController::class);
