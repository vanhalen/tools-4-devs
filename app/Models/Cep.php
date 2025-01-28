<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cep extends Model
{
    use HasFactory;
    protected $table = 'cep';

    protected $fillable = [
        'id',
        'cep',
        'logradouro',
        'complemento',
        'bairro',
        'localidade',
        'uf',
        'estado',
        'regiao',
        'ibge',
        'gia',
        'ddd',
        'siafi',
        'localizacao_tipo',
        'localizacao_longitude',
        'localizacao_latitude',
        'consultado_viacep',
        'consultado_brasilapi',
    ];
}
