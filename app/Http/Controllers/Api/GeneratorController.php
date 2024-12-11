<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GeneratorController extends Controller
{
    public function cpf(Request $request)
    {
        // Captura os parâmetros opcionais
        $formatted = $request->query('formatted', true); // Default é true (com pontuação)
        $uf = $request->query('uf', null);       // Default é null (qualquer estado)

        // Gerar CPF com base nos parâmetros
        $cpf = $this->generateCPF($uf);

        // Formatar o CPF, se necessário
        if ($formatted === 'false' || $formatted === false) {
            $formatted = false;
        } else {
            $formatted = true;
        }

        if ($formatted) {
            $cpf = $this->formatCPF($cpf);
        }

        // Retornar o CPF em formato JSON
        return response()->json([
            'status' => true,
            'message' => $cpf
        ], 200);
    }

    /**
     * Gera um CPF válido aleatório ou com base no estado.
     *
     * @param string|null $estado
     * @return string
     */
    private function generateCPF($estado = null)
    {
        $cpf = [];

        // Gera os 8 primeiros dígitos do CPF
        for ($i = 0; $i < 8; $i++) {
            $cpf[] = random_int(0, 9);
        }

        // Adiciona o dígito correspondente ao estado, se especificado
        $cpf[] = $this->getStateDigit($estado);

        // Calcula os dois dígitos verificadores
        $cpf[] = $this->calculateDigit($cpf);
        $cpf[] = $this->calculateDigit($cpf);

        // Retorna o CPF como string
        return implode('', $cpf);
    }

    /**
     * Calcula um dígito verificador para o CPF.
     *
     * @param array $base
     * @return int
     */
    private function calculateDigit(array $base)
    {
        $factor = count($base) + 1;
        $sum = 0;

        foreach ($base as $digit) {
            $sum += $digit * $factor--;
        }

        $remainder = $sum % 11;
        return $remainder < 2 ? 0 : 11 - $remainder;
    }

    /**
     * Retorna o dígito correspondente ao estado.
     *
     * @param string|null $estado
     * @return int
     */
    private function getStateDigit($estado = null)
    {
        // Mapeamento de estados para seus dígitos (último dígito antes dos verificadores)
        $stateDigits = [
            'SP' => 8, 'RJ' => 7, 'MG' => 6, 'ES' => 5, 'BA' => 4,
            'SE' => 4, 'PE' => 3, 'AL' => 2, 'PB' => 2, 'RN' => 2,
            'CE' => 1, 'PI' => 1, 'MA' => 0, 'PA' => 0, 'AM' => 0,
            'RO' => 0, 'AC' => 0, 'RR' => 0, 'AP' => 0, 'TO' => 0,
            'DF' => 9, 'GO' => 9, 'MT' => 9, 'MS' => 9, 'RS' => 0,
            'SC' => 0, 'PR' => 0
        ];

        // Retorna o dígito correspondente ao estado ou um aleatório se não especificado
        return $stateDigits[strtoupper($estado)] ?? random_int(0, 9);
    }

    /**
     * Formata um CPF com pontuação.
     *
     * @param string $cpf
     * @return string
     */
    private function formatCPF($cpf)
    {
        return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
    }
}
