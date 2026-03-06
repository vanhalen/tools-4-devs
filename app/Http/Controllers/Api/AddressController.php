<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use App\Services\CepService;
use App\Services\CidadeService;
use Illuminate\Http\Request;

/**
 * Responsável pela manipulação de endereços
 */
class AddressController extends Controller
{
    use ApiResponser;
    protected $cepService;
    protected $cidadeService;

    public function __construct(
        CepService $cep,
        CidadeService $cidade,
    ){
        $this->cepService = $cep;
        $this->cidadeService = $cidade;
    }

    /**
     * Busca um endereço a partir do CEP.
     *
     * @param string $cep
     * @return string
     * @throws \Exception
     */
    public function searchCep(Request $request) {
        try {
            $cep = $request->query('cep');

            // Busca o endereço
            $endereco = $this->cepService->buscarCep($cep);

            return $this->successResponse(['endereco' => $endereco]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
    /**
     * Busca um endereço a partir do nome da rua fornecido
     * e retorna no máximo 50 itens.
     * Por padrão sincroniza com ViaCEP para lista completa; use apenas_db=1 para só a base.
     *
     * @throws \Exception
     */
    public function searchStreet(Request $request) {
        try {
            $uf = $request->query('uf');
            $city = $request->query('city');
            $street = $request->query('street');
            $apenasDb = filter_var($request->query('apenas_db', false), FILTER_VALIDATE_BOOLEAN);

            $results = $this->cepService->buscarRua($uf, $city, $street, $apenasDb);

            return $this->successResponse(['endereco' => $results]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }


    /**
     * Busca ou lista cidades.
     * Tem como parâmetros opcionais o UF e nome da cidade
     *
     * @throws \Exception
     */
    public function searchCity(Request $request) {
        try {
        $uf = $request->query('uf');
        $city = $request->query('city');

        $results = $this->cidadeService->buscarCidade($uf, $city);

            return $this->successResponse(['cidade' => $results]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

}
