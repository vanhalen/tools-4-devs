<?php

namespace App\Services;

class RgService
{

    /**
     * Valida um RG de 9 dígitos.
     * É importante ter em mente que o RG não possui uma regra unificada
     * entre os estados, sendo assim, só contemplei a regra de 9 dígitos
     * pois os RG's que possuem menos, cada um possui uma regra específica.
     * Existem casos de não ter uma regra, podendo colocar números aleatórios.
     *
     * @param string $rg
     * @return bool
     */
    public function validate(string $rg): bool
    {
        // Remove caracteres não numéricos
        $rg = preg_replace('/\D/', '', $rg);

        // Verifica se o RG tem 9 dígitos
        if (strlen($rg) !== 9) {
            return false;
        }

        // Verifica se todos os caracteres são iguais (ex.: 11111111)
        if (preg_match('/(\d)\1{7,8}/', $rg)) {
            return false;
        }

        // Calcula o dígito verificador
        $peso = 2;
        $soma = 0;

        // Soma ponderada dos 8 primeiros dígitos
        for ($i = 0; $i < 8; $i++) {
            $soma += $rg[$i] * $peso;
            $peso++;
        }

        // Calcula o dígito verificador
        $resto = $soma % 11;
        $digitoVerificador = $resto < 2 ? 0 : 11 - $resto;

        // Valida o dígito verificador
        return $rg[8] == $digitoVerificador;
    }

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
        $factor = 2; // Peso inicial
        $sum = 0;

        // Multiplica cada dígito pelo fator, começando do primeiro dígito
        foreach ($base as $digit) {
            $sum += $digit * $factor++;
        }

        $remainder = $sum % 11;

        // Regra para calcular o dígito verificador
        if ($remainder === 0 || $remainder === 1) {
            return 0; // Alguns estados consideram 0 nesses casos
        }

        return 11 - $remainder;
    }


    private function formatRG($rg)
    {
        return substr($rg, 0, 2) . '.' . substr($rg, 2, 3) . '.' . substr($rg, 5, 3) . '-' . substr($rg, 8, 1);
    }
}
