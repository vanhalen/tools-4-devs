<?php

namespace App\Services;

class CnpjService
{
    /**
     * Gera um CNPJ válido.
     *
     * @param bool $formatted
     * @return string
     */
    public function generate($formatted = true)
    {
        // Gera o CNPJ
        $cnpj = $this->generateCNPJ();

        // Formata o CNPJ, se necessário
        return $formatted ? $this->formatCNPJ($cnpj) : $cnpj;
    }

    private function generateCNPJ()
    {
        $cnpj = [];

        // Gera os 12 primeiros dígitos
        for ($i = 0; $i < 12; $i++) {
            $cnpj[] = random_int(0, 9);
        }

        // Calcula os dois dígitos verificadores
        $cnpj[] = $this->calculateDigit($cnpj);
        $cnpj[] = $this->calculateDigit($cnpj);

        return implode('', $cnpj);
    }

    private function calculateDigit(array $base)
    {
        $factors = count($base) === 12 ? [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2] : [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $sum = 0;

        foreach ($base as $index => $digit) {
            $sum += $digit * $factors[$index];
        }

        $remainder = $sum % 11;
        return $remainder < 2 ? 0 : 11 - $remainder;
    }

    private function formatCNPJ($cnpj)
    {
        return substr($cnpj, 0, 2) . '.' . substr($cnpj, 2, 3) . '.' . substr($cnpj, 5, 3) . '/' . substr($cnpj, 8, 4) . '-' . substr($cnpj, 12, 2);
    }
}
