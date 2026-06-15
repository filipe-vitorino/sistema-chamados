<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResponsavelController;


Route::get('/', function () {
    return view('welcome');
});

Route::resource(
    'responsaveis',
    ResponsavelController::class
);
