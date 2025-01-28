<?php

namespace App\Services;

use Exception;

class BrasilApiService
{
    /**
     * Busca o endereço pelo CEP usando a API BrasilAPI.
     *
     * @param string $cep
     * @return array
     * @throws Exception
     */
    public function buscarEnderecoPorCep($cep)
    {
        // Remove caracteres inválidos do CEP
        $cep = preg_replace('/[^0-9]/', '', $cep);

        // Valida o CEP
        if (strlen($cep) !== 8) {
            throw new Exception("CEP inválido. Deve conter 8 dígitos.");
        }

        // Monta a URL da API
        $url = "https://brasilapi.com.br/api/cep/v2/{$cep}";

        // Faz a requisição
        $response = file_get_contents($url);

        // Verifica se houve erro
        if ($response === false) {
            throw new Exception("Erro ao consultar a API BrasilAPI.");
        }

        // Decodifica a resposta JSON
        $data = json_decode($response, true);

        // Verifica se o CEP foi encontrado
        if (isset($data['erro']) && $data['erro'] === true) {
            throw new Exception("CEP não encontrado.");
        }

        return $data;
    }
}
