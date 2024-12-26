<?php

namespace App\Services;

use InvalidArgumentException;

class TituloEleitorService
{
    /**
     * Valida um Título de Eleitor.
     *
     * @param string $titulo
     * @return bool
     */
    public function validate(string $titulo): bool
    {
        // Remove caracteres não numéricos
        $titulo = preg_replace('/\D/', '', $titulo);

        // Verifica se o Título de Eleitor tem exatamente 12 dígitos
        if (strlen($titulo) !== 12) {
            return false;
        }

        // Extrai os componentes do Título de Eleitor
        $base = substr($titulo, 0, 8); // Números randômicos
        $uf = substr($titulo, 8, 2);  // Unidade da Federação
        $dv1 = (int)$titulo[10];     // Primeiro dígito verificador
        $dv2 = (int)$titulo[11];     // Segundo dígito verificador

        // Verifica se a UF é válida (01 a 28)
        if ((int)$uf < 1 || (int)$uf > 28) {
            return false;
        }

        // Corrige base para array numérico para cálculos precisos
        $baseArray = array_map('intval', str_split($base));

        // Cálculo do primeiro dígito verificador (DV1)
        $soma = 0;
        $pesos = [2, 3, 4, 5, 6, 7, 8, 9];
        foreach ($baseArray as $i => $numero) {
            $soma += $numero * $pesos[$i];
        }
        $resto = $soma % 11;
        $calculatedDv1 = $resto === 10 ? 0 : $resto;

        // Regra especial para SP (01) e MG (02)
        if (in_array((int)$uf, [1, 2]) && $resto === 0) {
            $calculatedDv1 = 1;
        }

        if ($calculatedDv1 !== $dv1) {
            return false;
        }

        // Cálculo do segundo dígito verificador (DV2)
        $soma = 0;
        $pesosDv2 = [7, 8, 9];
        $ufArray = array_map('intval', str_split($uf));
        $dadosParaDv2 = array_merge($ufArray, [$calculatedDv1]);

        foreach ($dadosParaDv2 as $i => $numero) {
            $soma += $numero * $pesosDv2[$i];
        }
        $resto = $soma % 11;
        $calculatedDv2 = $resto === 10 ? 0 : $resto;

        // Regra especial para SP (01) e MG (02)
        if (in_array((int)$uf, [1, 2]) && $resto === 0) {
            $calculatedDv2 = 1;
        }

        return $calculatedDv2 === $dv2;
    }


    /**
     * Gera um Título de Eleitor válido.
     *
     * @param bool $formatted Retornar o título formatado (###.#####.####)?
     * @param int|null $uf Unidade da Federação específica (01 a 28), ou null para gerar aleatoriamente.
     * @return string Título de Eleitor válido.
     */
    public function generate(bool $formatted = true, ?string $uf = null): string
    {
        $uf = $this->getStateCode($uf);
        // Valida o parâmetro UF
        if ($uf !== null && ($uf < 1 || $uf > 28)) {
            throw new InvalidArgumentException("UF deve estar entre 01 e 28.");
        }

        do {
            // Gera 8 dígitos randômicos (base)
            $baseArray = [];
            for ($i = 0; $i < 8; $i++) {
                $baseArray[] = rand(0, 9);
            }
            $base = implode('', $baseArray);

            // Gera a UF aleatoriamente caso não tenha sido especificada
            $uf = $uf ?? rand(1, 28);
            $ufStr = str_pad((string)$uf, 2, '0', STR_PAD_LEFT);

            // Cálculo do primeiro dígito verificador (DV1)
            $soma = 0;
            $pesos = [2, 3, 4, 5, 6, 7, 8, 9];
            foreach ($baseArray as $i => $numero) {
                $soma += $numero * $pesos[$i];
            }
            $resto = $soma % 11;
            $dv1 = ($resto === 10) ? 0 : $resto;

            // Regra especial para SP (01) e MG (02)
            if (in_array((int)$uf, [1, 2]) && $resto === 0) {
                $dv1 = 1;
            }

            // Cálculo do segundo dígito verificador (DV2)
            $soma = 0;
            $pesosDv2 = [7, 8, 9];
            $ufArray = array_map('intval', str_split($ufStr));
            $dadosParaDv2 = array_merge($ufArray, [$dv1]);

            foreach ($dadosParaDv2 as $i => $numero) {
                $soma += $numero * $pesosDv2[$i];
            }
            $resto = $soma % 11;
            $dv2 = ($resto === 10) ? 0 : $resto;

            // Regra especial para SP (01) e MG (02)
            if (in_array((int)$uf, [1, 2]) && $resto === 0) {
                $dv2 = 1;
            }

            // Monta o Título de Eleitor
            $titulo = $base . $ufStr . $dv1 . $dv2;

        } while (!$this->validate($titulo)); // Garante que o título gerado seja válido

        // Retorna o título formatado ou não
        return $formatted ? $this->formatTitulo($titulo) : $titulo;
    }

    public function getUf(string $titulo): ?string
    {
        $titulo = preg_replace('/\D/', '', $titulo);
        $uf = intval(substr($titulo, 8, 2));  // Unidade da Federação
        return $this->getStateStr($uf);
    }

    private function getStateStr($uf): ?string
    {
        return array_search($uf, $this->stateCodes, true) ?: null;
    }

    private function getStateCode($uf = null): int
    {
        return $this->stateCodes[strtoupper($uf)] ?? str_pad(random_int(1, 27), 2, '0', STR_PAD_LEFT);
    }

    private function formatTitulo($titulo): string
    {
        return substr($titulo, 0, 4) . ' ' . substr($titulo, 4, 4) . ' ' . substr($titulo, 8, 4);
    }

    private array $stateCodes = [
        'SP' => 1, 'MG' => 2, 'RJ' => 3, 'RS' => 4, 'BA' => 5,
        'PR' => 6, 'CE' => 7, 'PE' => 8, 'SC' => 9, 'GO' => 10,
        'MA' => 11, 'PB' => 12, 'PA' => 13, 'ES' => 14, 'PI' => 15,
        'RN' => 16, 'AL' => 17, 'MT' => 18, 'MS' => 19, 'DF' => 20,
        'SE' => 21, 'AM' => 22, 'RO' => 23, 'AC' => 24, 'AP' => 25,
        'RR' => 26, 'TO' => 27, 'ZZ' => 28
    ];
}