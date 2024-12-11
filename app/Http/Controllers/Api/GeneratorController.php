<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CpfService;
use Illuminate\Http\Request;

/**
 * Responsável pela geração de dados
 */
class GeneratorController extends Controller
{
    protected $cpfService;

    public function __construct(CpfService $cpfService)
    {
        $this->cpfService = $cpfService;
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

            return response()->json([
                'status' => true,
                'data' => [
                    'cpf' => $cpf
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'errors' => [
                    'message' => $e->getMessage()
                ]
            ], 400);
        }
    }
}
