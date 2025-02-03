<?php

namespace App\Services;

use App\Models\Cidade;

class CidadeService
{

    public function __construct(){}

    /**
     * Realiza a busca ou retorna a listagem completa de Cidades.
     *
     * @param string $uf
     * @param string $city
     */
    public function buscarCidade($uf, $city)
    {
        // Inicia a query para buscar no banco
        $query = Cidade::query();

        // Valida a UF
        if (!is_null($uf)) {
            if(strlen($uf) !== 2) {
                throw new \Exception("UF inválida. Certifique-se de que possui exatamente 2 caracteres.");
            }

            $query->where('uf', strtoupper($uf));
        }

        // Valida a cidade
        if (!is_null($city)) {
            if(strlen($city) < 3){
                throw new \Exception("O nome da cidade deve conter ao menos 3 caracteres.");
            }

            $query->where('cidade', 'LIKE', '%' . $city . '%');
        }

        $results = $query->get();

        // Retorna os resultados encontrados ou erro se nenhum resultado for encontrado
        if (empty($results)) {
            throw new \Exception("Nenhuma cidade encontrada para os critérios fornecidos.");
        }

        return $results;
    }
}
