<?php

use App\Http\Controllers\Api\GeneratorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/users', function (Request $request) {
//     return $request->user();
// });
// })->middleware('auth:sanctum'); // Verifica se o usuário está logado (Desnecessário)


Route::get('/generator/cpf', [GeneratorController::class, 'cpf']);
// http://127.0.0.1:8000/api/generator/cpf?formatted=true&uf=MG

Route::get('/generator/rg', [GeneratorController::class, 'rg']);
// http://127.0.0.1:8000/api/generator/rg?formatted=true

Route::get('/generator/cnpj', [GeneratorController::class, 'cnpj']);
// http://127.0.0.1:8000/api/generator/cnpj?formatted=false

Route::get('/generator/titulo-eleitor', [GeneratorController::class, 'tituloEleitor']);
// http://127.0.0.1:8000/api/generator/titulo-eleitor?formatted=true&uf=MG

Route::get('/generator/pis-pasep', [GeneratorController::class, 'pisPasep']);
// http://127.0.0.1:8000/api/generator/pis-pasep?formatted=true

Route::get('/generator/certidao', [GeneratorController::class, 'certidao']);
http://127.0.0.1:8000/api/generator/certidao?formatted=true&type=obito&year=2024&uf=SP&notary=2530

Route::get('/generator/senha', [GeneratorController::class, 'senha']);
//http://127.0.0.1:8000/api/generator/senha?length=12&uppercase=true&lowercase=false&numbers=false&specials=false

Route::get('/generator/endereco', [GeneratorController::class, 'endereco']);
//http://127.0.0.1:8000/api/generator/endereco?uf=SP&formatted=false