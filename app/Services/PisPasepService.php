<?php

namespace App\Services;

class PisPasepService
{
    /**
     * Gera um PIS/PASEP válido.
     *
     * @param bool $formatted
     * @return string
     */
    public function generate($formatted = true)
    {
        // Gera o número do PIS/PASEP
        $pispasep = $this->generatePisPasep();

        // Formata o número, se necessário
        return $formatted ? $this->formatPisPasep($pispasep) : $pispasep;
    }

    private function generatePisPasep()
    {
        $pispasep = [];

        // Gera os primeiros 10 dígitos
        for ($i = 0; $i < 10; $i++) {
            $pispasep[] = random_int(0, 9);
        }

        // Calcula o dígito verificador
        $pispasep[] = $this->calculateDigit($pispasep);

        return implode('', $pispasep);
    }

    private function calculateDigit(array $base)
    {
        $weights = [3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $sum = 0;

        // Multiplica cada dígito pelo peso correspondente
        foreach ($base as $index => $digit) {
            $sum += $digit * $weights[$index];
        }

        $remainder = $sum % 11;

        // Define o dígito verificador
        if ($remainder === 0 || $remainder === 1) {
            return 0;
        }

        return 11 - $remainder;
    }

    private function formatPisPasep($pispasep)
    {
        return substr($pispasep, 0, 3) . '.' . substr($pispasep, 3, 5) . '.' . substr($pispasep, 8, 2) . '-' . substr($pispasep, 10, 1);
    }
}
