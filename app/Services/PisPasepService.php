<?php

namespace App\Services;

class PisPasepService
{
    /**
     * Valida um número PIS/PASEP.
     *
     * @param string $pispasep
     * @return bool
     */
    public function validate(string $pispasep): bool
    {
        // Remove caracteres não numéricos
        $pispasep = preg_replace('/\D/', '', $pispasep);

        // Verifica se o número do PIS/PASEP tem exatamente 11 dígitos
        if (strlen($pispasep) !== 11) {
            return false;
        }

        // Extrai os 10 primeiros dígitos (base) e o dígito verificador
        $base = array_map('intval', str_split(substr($pispasep, 0, 10)));
        $dv = (int) $pispasep[10];

        // Calcula o dígito verificador esperado
        $calculatedDv = $this->calculateDigit($base);

        // Verifica se o dígito verificador está correto
        return $dv === $calculatedDv;
    }

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
