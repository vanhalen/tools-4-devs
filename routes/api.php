<?php

use App\Http\Controllers\Api\GeneratorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/users', function (Request $request) {
//     return $request->user();
// });
// })->middleware('auth:sanctum'); // Verifica se o usuário está logado (Desnecessário)


Route::get('/generator/cpf', [GeneratorController::class, 'cpf']);