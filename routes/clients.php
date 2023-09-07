<?php

use App\Http\Controllers\clients\facturationController;
use App\Http\Controllers\clients\pqrsController;
use App\Http\Controllers\landingPageController;
use Illuminate\Support\Facades\Route;

// Usuarios Autorizados: Clientes
Route::middleware(['auth', 'role:cliente'])->group(function () {

    //Vista: Dashboard 
    Route::get('/', function () {
        return view("clients.dashboard");
    })->name("clients.dashboard");

    //Funcionalidad PQRS
    Route::resource('/pqrs', pqrsController::class)->names('clients.pqrs');

    //Funcionalidad Facturation
    Route::resource('/facturation', facturationController::class)->names('clients.facturation');

});
