<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\controllerEstudiante;
use App\Http\Controllers\controllerNota;

// API Routes
Route::prefix('estudiantes')->group(function () {
    Route::get('/', [controllerEstudiante::class, 'index']); 
    Route::post('/', [controllerEstudiante::class, 'store']); 
    Route::put('/{cod}', [controllerEstudiante::class, 'update']); 
    Route::delete('/{cod}', [controllerEstudiante::class, 'destroy']); 
    Route::get('/{cod}/notas', [controllerNota::class, 'getNotasByEstudiante']); 
});

Route::prefix('notas')->group(function () {
    Route::post('/{codEstudiante}', [controllerNota::class, 'store']); 
    Route::put('/{id}', [controllerNota::class, 'update']); 
    Route::delete('/{id}', [controllerNota::class, 'destroy']); 
});

