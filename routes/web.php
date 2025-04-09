<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormularioController;

Route::get('/', function () {
    return redirect()->route('formulario.create');
});

 
Route::get('/formulario', [FormularioController::class, 'create'])->name('formulario.create');
Route::post('/formulario', [FormularioController::class, 'store'])->name('formulario.store');
Route::get('/formulario/dados', [FormularioController::class, 'show'])->name('formulario.show');
Route::put('/formulario/{id}', [FormularioController::class, 'update'])->name('formulario.update');
