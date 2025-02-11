<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use App\Services\StringService;
use Illuminate\Http\Request;

/**
 * Responsável pelas operações de análise de texto.
 */
class StringController extends Controller
{
    use ApiResponser;

    protected $stringService;

    public function __construct(StringService $stringService)
    {
        $this->stringService = $stringService;
    }

    /**
     * Realiza a análise de um texto e retorna estatísticas detalhadas.
     * Contagem de caracteres, espaços, numeros, linhas, tempo de leitura...
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function characterCount(Request $request)
    {
        try {
            // Obtém o texto do request
            $text = $request->input('text');

            // Verifica se o texto foi fornecido
            if (!$text) {
                return $this->errorResponse('O campo "text" é obrigatório.', 400);
            }

            // Chama o serviço de análise
            $result = $this->stringService->analyzeText($text);

            return $this->successResponse($result);

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}

