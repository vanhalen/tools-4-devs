<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use App\Services\CepService;
use Illuminate\Http\Request;

/**
 * Responsável pela manipulação de endereços
 */
class AddressController extends Controller
{
    use ApiResponser;
    protected $cepService;

    public function __construct(
        CepService $cep,
    ){
        $this->cepService = $cep;
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
     * Busca um endereço da rua
     *
     * @throws \Exception
     */
    public function searchStreet(Request $request) {
        try {
        $uf = $request->query('uf');
        $city = $request->query('city');
        $street = $request->query('street');

        $results = $this->cepService->buscarRua($uf, $city, $street);

            return $this->successResponse(['endereco' => $results]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

}
