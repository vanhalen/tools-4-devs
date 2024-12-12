<?php

namespace App\Services;

class CpfService
{
    /**
     * Gera um CPF válido.
     *
     * @param bool $formatted
     * @param string|null $uf
     * @return string
     */
    public function generate($formatted = true, $uf = null)
    {
        // Gera o CPF
        $cpf = $this->generateCPF($uf);

        // Formata o CPF, se necessário
        return $formatted ? $this->formatCPF($cpf) : $cpf;
    }

    private function generateCPF($uf = null)
    {
        $cpf = [];

        // Gera os 8 primeiros dígitos
        for ($i = 0; $i < 8; $i++) {
            $cpf[] = random_int(0, 9);
        }

        // Adiciona o dígito do estado
        $cpf[] = $this->getStateDigit($uf);

        // Calcula os dois dígitos verificadores
        $cpf[] = $this->calculateDigit($cpf);
        $cpf[] = $this->calculateDigit($cpf);

        return implode('', $cpf);
    }

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

    private function getStateDigit($estado = null)
    {
        $stateDigits = [
            'SP' => 8, 'RJ' => 7, 'MG' => 6, 'ES' => 5, 'BA' => 4,
            'SE' => 4, 'PE' => 3, 'AL' => 2, 'PB' => 2, 'RN' => 2,
            'CE' => 1, 'PI' => 1, 'MA' => 0, 'PA' => 0, 'AM' => 0,
            'RO' => 0, 'AC' => 0, 'RR' => 0, 'AP' => 0, 'TO' => 0,
            'DF' => 9, 'GO' => 9, 'MT' => 9, 'MS' => 9, 'RS' => 0,
            'SC' => 0, 'PR' => 0
        ];

        return $stateDigits[strtoupper($estado)] ?? random_int(0, 9);
    }

    private function formatCPF($cpf)
    {
        return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
    }
}
