<?php

namespace App\Services;

class CertidaoService
{

    /**
     * Valida o número de matrícula da certidão.
     *
     * @param string $matricula
     * @return bool
     */
    public function validate(string $matricula): bool
    {
        // Remove formatação
        $matricula = preg_replace('/[^0-9]/', '', $matricula);

        // Verifica se a matrícula possui exatamente 32 dígitos
        if (strlen($matricula) !== 32) {
            return false;
        }

        // Divide a matrícula em partes
        $base = substr($matricula, 0, 30); // Os primeiros 30 dígitos
        $dv = substr($matricula, 30, 2);  // Últimos 2 dígitos (DV)

        // Calcula o dígito verificador
        $calculatedDv = $this->calculateDv($base);

        // Compara o DV calculado com o DV fornecido
        return $calculatedDv === $dv;
    }

    /**
     * Calcula o dígito verificador (DV) com base na regra fornecida.
     *
     * @param string $base
     * @return string
     */
    private function calculateDv(string $base): string
    {
        // Calcula o primeiro dígito verificador (primeiro peso fixo)
        $firstDv = $this->calculateFirstDv($base);

        // Calcula o segundo dígito verificador usando o primeiro DV
        $secondDv = $this->calculateSecondDv($base, $firstDv);

        return str_pad($firstDv, 1, '0', STR_PAD_LEFT) . str_pad($secondDv, 1, '0', STR_PAD_LEFT);
    }

    /**
     * Calcula o primeiro dígito verificador com base nos pesos fixos ajustados.
     *
     * @param string $base
     * @return int
     */
    private function calculateFirstDv(string $base): int
    {
        $pesos = [2, 3, 4, 5, 6, 7, 8, 9, 10, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9]; 
        $sum = 0;

        foreach (str_split($base) as $index => $digit) {
            $sum += (int)$digit * $pesos[$index];
        }

        $remainder = $sum % 11;

        // Se o resto for 10, retorna 1. Caso contrário, retorna o resto.
        return $remainder === 10 ? 1 : $remainder;
    }

    /**
     * Calcula o segundo dígito verificador com base no primeiro DV.
     *
     * @param string $base
     * @param int $firstDv
     * @return int
     */
    private function calculateSecondDv(string $base, int $firstDv): int
    {
        $pesos = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 0, 1, 2, 3, 4, 5, 6, 7, 8];
        $sum = $firstDv * 9; // O primeiro DV influencia diretamente o segundo cálculo.

        foreach (str_split($base) as $index => $digit) {
            $sum += (int)$digit * $pesos[$index];
        }

        $remainder = $sum % 11;

        // Se o resto for 10, retorna 1. Caso contrário, retorna o resto.
        return $remainder === 10 ? 1 : $remainder;
    }

    #################################################
    ################   GERADOR   ####################
    #################################################
    /**
     * Gera um número de matrícula para certidão.
     * OBS.: O ano do documento deve ser a partir de 2010
     *
     * @param string $tipo
     * @param string|null $uf
     * @param int|null $anoRegistro
     * @param int|null $codigoCartorio
     * @param bool $formatted
     * @return string
     * @throws \Exception
     */
    public function generate($tipo = 'nascimento', $uf = null, $anoRegistro = null, $codigoCartorio = null, $formatted = true)
    {
        // Valida o tipo de certidão
        $this->validateTipo($tipo);

        // Define UF (Estado), ano e cartório aleatoriamente se não fornecidos
        $uf = $uf ?? $this->getRandomUf();
        $anoRegistro = $anoRegistro ?? random_int(2010, date('Y')); // Ano mínimo de 2010
        $codigoCartorio = $codigoCartorio ?? random_int(1, 99);

        // Gera o número de matrícula sem os DVs
        $matricula = $this->generateMatricula($tipo, $uf, $anoRegistro, $codigoCartorio);

        // Calcula os dígitos verificadores
        $dv = $this->calculateDv($matricula);

        // Adiciona os DVs no final da matrícula
        $matricula .= $dv;

        // Formata o número, se necessário
        return $formatted ? $this->formatMatricula($matricula) : $matricula;
    }

    /**
     * Gera a base da matrícula sem os DVs.
     */
    private function generateMatricula($tipo, $uf, $anoRegistro, $codigoCartorio): string
    {
        return implode('', [
            str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT), // Sequencial único
            $this->getUfCode($uf),                                    // Código da UF
            str_pad($codigoCartorio, 2, '0', STR_PAD_LEFT),           // Código do cartório
            str_pad($anoRegistro, 4, '0', STR_PAD_LEFT),              // Ano do registro
            $this->getTipoCode($tipo),                                // Tipo de registro
            str_pad(random_int(10000, 99999), 5, '0', STR_PAD_LEFT),  // Número do livro
            str_pad(random_int(10, 999), 3, '0', STR_PAD_LEFT),       // Número da folha
            str_pad(random_int(1000000, 9999999), 7, '0', STR_PAD_LEFT) // Número do termo
        ]);
    }

    /**
     * Formata a matrícula em blocos legíveis.
     */
    private function formatMatricula($matricula): string
    {
        return substr($matricula, 0, 6) . ' ' . // Sequencial
            substr($matricula, 6, 2) . ' ' . // UF
            substr($matricula, 8, 2) . ' ' . // Cartório
            substr($matricula, 10, 4) . ' ' . // Ano
            substr($matricula, 14, 1) . ' ' . // Tipo
            substr($matricula, 15, 5) . ' ' . // Livro
            substr($matricula, 20, 3) . ' ' . // Folha
            substr($matricula, 23, 7) . '-' . // Termo
            substr($matricula, 30, 2);       // Dígitos verificadores
    }

    private function getUfCode($uf)
    {
        $ufCodes = [
            'AC' => '01', 'AL' => '02', 'AP' => '03', 'AM' => '04', 'BA' => '05',
            'CE' => '06', 'DF' => '07', 'ES' => '08', 'GO' => '09', 'MA' => '10',
            'MT' => '11', 'MS' => '12', 'MG' => '13', 'PA' => '14', 'PB' => '15',
            'PR' => '16', 'PE' => '17', 'PI' => '18', 'RJ' => '19', 'RN' => '20',
            'RS' => '21', 'RO' => '22', 'RR' => '23', 'SC' => '24', 'SP' => '25',
            'SE' => '26', 'TO' => '27'
        ];

        if (!isset($ufCodes[strtoupper($uf)])) {
            throw new \Exception("UF inválida: {$uf}");
        }

        return $ufCodes[strtoupper($uf)];
    }

    private function getTipoCode($tipo)
    {
        $tipoCodes = [
            'nascimento' => '1',
            'casamento' => '2',
            'obito' => '3',
            'casamento-religioso' => '4'
        ];

        if (!isset($tipoCodes[strtolower($tipo)])) {
            throw new \Exception("Tipo de certidão inválido: {$tipo}");
        }

        return $tipoCodes[strtolower($tipo)];
    }

    private function getRandomUf()
    {
        $ufs = [
            'AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA',
            'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN',
            'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'
        ];

        return $ufs[array_rand($ufs)];
    }

    private function validateTipo($tipo)
    {
        $tiposValidos = ['nascimento', 'casamento', 'obito', 'casamento-religioso'];

        if (!in_array(strtolower($tipo), $tiposValidos)) {
            throw new \Exception("Tipo de certidão inválido. Tipos válidos: " . implode(', ', $tiposValidos));
        }
    }
}
