<?php

use App\Http\Controllers\Api\GeneratorController;
use App\Http\Controllers\Api\NetworkController;
use App\Http\Controllers\Api\ValidatorController;
use App\Http\Controllers\Api\HolidayController;
use Illuminate\Support\Facades\Route;
// use Illuminate\Http\Request;

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
// http://127.0.0.1:8000/api/generator/certidao?formatted=true&type=obito&year=2024&uf=SP&notary=2530

Route::get('/generator/senha', [GeneratorController::class, 'senha']);
//http://127.0.0.1:8000/api/generator/senha?length=12&uppercase=true&lowercase=false&numbers=false&specials=false

Route::get('/generator/endereco', [GeneratorController::class, 'endereco']);
//http://127.0.0.1:8000/api/generator/endereco?uf=SP&formatted=false

Route::get('/generator/lorem-ipsum', [GeneratorController::class, 'loremIpsum']);
// http://127.0.0.1:8000/api/generator/lorem-ipsum?length=50&type=palavras&format=html



################
# VALIDADORES
################

Route::get('/validator/cpf', [ValidatorController::class, 'cpf']);
// http://127.0.0.1:8000/api/validator/cpf?cpf=43973515387

Route::get('/validator/rg', [ValidatorController::class, 'rg']);
// http://127.0.0.1:8000/api/validator/rg?rg=43973515387

Route::get('/validator/cnpj', [ValidatorController::class, 'cnpj']);
// http://127.0.0.1:8000/api/validator/cnpj?cnpj=64242290928912

Route::get('/validator/titulo-eleitor', [ValidatorController::class, 'tituloEleitor']);
// http://127.0.0.1:8000/api/validator/titulo-eleitor?titulo=528507860990

Route::get('/validator/pis-pasep', [ValidatorController::class, 'pisPasep']);
// http://127.0.0.1:8000/api/validator/pis-pasep?pispasep=528507860990

Route::get('/validator/ip', [NetworkController::class, 'validateIp']);
// http://127.0.0.1:8000/api/validator/ip?ip=127.0.0.0



################
# NETWORK - REDE
################

Route::get('/network/ip', [NetworkController::class, 'getIp']);
// http://127.0.0.1:8000/api/network/ip

Route::get('/network/browser', [NetworkController::class, 'getBrowser']);
// http://127.0.0.1:8000/api/network/browser

Route::get('/network/system', [NetworkController::class, 'getSystem']);
// http://127.0.0.1:8000/api/network/system

Route::get('/network/resolve-dns', [NetworkController::class, 'resolveDns']);
// http://127.0.0.1:8000/api/network/resolve-dns?host=google.com

Route::get('/network/port-test', [NetworkController::class, 'portTest']);
// http://127.0.0.1:8000/api/network/port-test?host=google.com.br&port=80



###############
# FERIADOS
###############
Route::get('/holidays/{year}', [HolidayController::class, 'index']);
// http://127.0.0.1:8000/api/holidays/2024
