<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use App\Services\CpfService;
use App\Services\CnpjService;
use Illuminate\Http\Request;

/**
 * Responsável pela geração de dados
 */
class GeneratorController extends Controller
{
    use ApiResponser;
    protected $cpfService;
    protected $cnpjService;

    public function __construct(CpfService $cpfService, CnpjService $cnpjService)
    {
        $this->cpfService = $cpfService;
        $this->cnpjService = $cnpjService;
    }

    /**
     * Gera um CPF válido.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cpf(Request $request)
    {
        try {
            // Captura os parâmetros opcionais
            $formatted = filter_var($request->query('formatted', true), FILTER_VALIDATE_BOOLEAN);
            $uf = $request->query('uf', null);

            // Gera o CPF
            $cpf = $this->cpfService->generate($formatted, $uf);

            return $this->successResponse(['cpf' => $cpf]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Gera um CNPJ válido.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cnpj(Request $request)
    {
        try {
            // Captura o parâmetro opcional
            $formatted = filter_var($request->query('formatted', true), FILTER_VALIDATE_BOOLEAN);

            // Gera o CNPJ
            $cnpj = $this->cnpjService->generate($formatted);

            return $this->successResponse(['cnpj' => $cnpj]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
