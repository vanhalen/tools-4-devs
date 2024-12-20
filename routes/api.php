<?php

use App\Http\Controllers\Api\GeneratorController;
use App\Http\Controllers\Api\NetworkController;
use App\Http\Controllers\Api\ValidatorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/users', function (Request $request) {
//     return $request->user();
// });
// })->middleware('auth:sanctum'); // Verifica se o usuário está logado (Desnecessário)


################
# GERADORES
################

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

Route::get('/generator/lorem-ipsum', [GeneratorController::class, 'loremIpsum']);
// http://127.0.0.1:8000/api/generator/lorem-ipsum?length=50&type=palavras&format=html


################
# NETWORK - REDE
################

Route::get('/network/ip', [NetworkController::class, 'getIp']);
// http://127.0.0.1:8000/api/network/ip

Route::get('/network/browser', [NetworkController::class, 'getBrowser']);
// http://127.0.0.1:8000/api/network/browser

Route::get('/network/system', [NetworkController::class, 'getSystem']);
// http://127.0.0.1:8000/api/network/system

Route::get('/network/validate-ip', [NetworkController::class, 'validateIp']);
// http://127.0.0.1:8000/api/network/validate-ip?ip=127.0.0.0

Route::get('/network/resolve-dns', [NetworkController::class, 'resolveDns']);
// http://127.0.0.1:8000/api/network/resolve-dns?host=google.com

Route::get('/network/test-port', [NetworkController::class, 'testPort']);
// http://127.0.0.1:8000/api/network/test-port?host=google.com.br&port=80


