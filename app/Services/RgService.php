<?php

namespace App\Services;

class RgService
{
    /**
     * Gera um RG válido.
     *
     * @param bool $formatted
     * @return string
     */
    public function generate($formatted = true)
    {
        // Gera o RG
        $rg = $this->generateRG();

        // Formata o RG, se necessário
        return $formatted ? $this->formatRG($rg) : $rg;
    }

    private function generateRG()
    {
        $rg = [];

        // Gera os 8 primeiros dígitos do RG
        for ($i = 0; $i < 8; $i++) {
            $rg[] = random_int(0, 9);
        }

        // Calcula o dígito verificador
        $rg[] = $this->calculateDigit($rg);

        return implode('', $rg);
    }

    private function calculateDigit(array $base)
    {
        $factor = 2;
        $sum = 0;

        // Multiplica cada dígito pelo fator, começando por 2
        foreach (array_reverse($base) as $digit) {
            $sum += $digit * $factor++;
        }

        $remainder = $sum % 11;

        // Dígito verificador varia conforme o resto
        if ($remainder === 0) {
            return 0;
        } elseif ($remainder === 1) {
            return 'X'; // Algumas regras permitem 'X' como dígito verificador
        } else {
            return 11 - $remainder;
        }
    }

    private function formatRG($rg)
    {
        return substr($rg, 0, 2) . '.' . substr($rg, 2, 3) . '.' . substr($rg, 5, 3) . '-' . substr($rg, 8, 1);
    }
}
