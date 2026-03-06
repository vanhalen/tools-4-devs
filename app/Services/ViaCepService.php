<?php

namespace App\Services;

use Exception;

class ViaCepService
{
    /**
     * Busca o endereço pelo CEP usando a API ViaCEP.
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
        $url = "https://viacep.com.br/ws/{$cep}/json/";

        // Faz a requisição
        $response = file_get_contents($url);

        // Verifica se houve erro
        if ($response === false) {
            throw new Exception("Erro ao consultar a API ViaCEP.");
        }

        // Decodifica a resposta JSON
        $data = json_decode($response, true);

        // Verifica se o CEP foi encontrado
        if (isset($data['erro']) && $data['erro'] === true) {
            throw new Exception("CEP não encontrado.");
        }

        return $data;
    }

    /**
     * Busca endereços por UF, cidade e logradouro usando a API ViaCEP.
     * Endpoint: https://viacep.com.br/ws/{uf}/{cidade}/{logradouro}/json/
     *
     * @param string $uf
     * @param string $cidade
     * @param string $logradouro
     * @return array Lista de endereços (array de arrays)
     * @throws Exception
     */
    public function buscarEnderecoPorRua(string $uf, string $cidade, string $logradouro): array
    {
        $uf = strtoupper(trim($uf));
        $cidade = trim($cidade);
        $logradouro = trim($logradouro);

        if (strlen($uf) !== 2) {
            throw new Exception("UF inválida. Deve conter 2 caracteres.");
        }

        if (strlen($cidade) < 3) {
            throw new Exception("Cidade deve conter ao menos 3 caracteres.");
        }

        if (strlen($logradouro) < 3) {
            throw new Exception("Logradouro deve conter ao menos 3 caracteres.");
        }

        $url = 'https://viacep.com.br/ws/' . rawurlencode($uf) . '/' . rawurlencode($cidade) . '/' . rawurlencode($logradouro) . '/json/';

        $response = file_get_contents($url);

        if ($response === false) {
            throw new Exception("Erro ao consultar a API ViaCEP.");
        }

        $data = json_decode($response, true);

        if (isset($data['erro']) && $data['erro'] === true) {
            return [];
        }

        // ViaCEP retorna array quando há vários resultados ou um único objeto quando há um
        if (!is_array($data)) {
            return [];
        }

        // Se for um único endereço (chaves como 'cep', 'logradouro'), normaliza para array
        if (isset($data['cep'])) {
            return [$data];
        }

        return $data;
    }
}
