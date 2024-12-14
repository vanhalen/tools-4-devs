<?php

namespace App\Services;

class TituloEleitorService
{
    /**
     * Gera um Título de Eleitor válido.
     *
     * @param bool $formatted
     * @param string|null $uf
     * @return string
     */
    public function generate($formatted = true, $uf = null)
    {
        // Gera o título
        $titulo = $this->generateTitulo($uf);

        // Formata o título, se necessário
        return $formatted ? $this->formatTitulo($titulo) : $titulo;
    }

    private function generateTitulo($uf = null)
    {
        $titulo = [];

        // Gera os 8 primeiros dígitos (número sequencial do título)
        for ($i = 0; $i < 8; $i++) {
            $titulo[] = random_int(0, 9);
        }

        // Determina o código do estado (2 dígitos)
        $titulo[] = $this->getStateCode($uf);

        // Calcula os dois dígitos verificadores
        $titulo[] = $this->calculateDigit($titulo);
        $titulo[] = $this->calculateDigit($titulo);

        return implode('', $titulo);
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

        // Dígito verificador é o resto, mas se for 10, substitui por 0
        return $remainder === 10 ? 0 : $remainder;
    }

    private function getStateCode($uf = null)
    {
        $stateCodes = [
            'AC' => 1, 'AL' => 2, 'AP' => 3, 'AM' => 4, 'BA' => 5,
            'CE' => 6, 'DF' => 7, 'ES' => 8, 'GO' => 9, 'MA' => 10,
            'MT' => 11, 'MS' => 12, 'MG' => 13, 'PA' => 14, 'PB' => 15,
            'PR' => 16, 'PE' => 17, 'PI' => 18, 'RJ' => 19, 'RN' => 20,
            'RS' => 21, 'RO' => 22, 'RR' => 23, 'SC' => 24, 'SP' => 25,
            'SE' => 26, 'TO' => 27
        ];

        // Retorna o código do estado ou um aleatório se não especificado
        return $stateCodes[strtoupper($uf)] ?? random_int(1, 27);
    }

    private function formatTitulo($titulo)
    {
        return substr($titulo, 0, 4) . ' ' . substr($titulo, 4, 4) . ' ' . substr($titulo, 8, 4);
    }
}