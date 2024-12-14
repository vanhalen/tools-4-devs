<?php

namespace App\Services;

class CertidaoService
{
    /**
     * Gera um número de matrícula para certidão.
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
        $anoRegistro = $anoRegistro ?? date('Y');
        $codigoCartorio = $codigoCartorio ?? random_int(1000, 9999);

        // Gera o número de matrícula
        $matricula = $this->generateMatricula($tipo, $uf, $anoRegistro, $codigoCartorio);

        // Formata o número, se necessário
        return $formatted ? $this->formatMatricula($matricula) : $matricula;
    }

    private function generateMatricula($tipo, $uf, $anoRegistro, $codigoCartorio)
    {
        $matricula = [];

        // Código da UF (2 dígitos)
        $matricula[] = $this->getUfCode($uf);

        // Código do Cartório (4 dígitos)
        $matricula[] = str_pad($codigoCartorio, 4, '0', STR_PAD_LEFT);

        // Ano do Registro (4 dígitos)
        $matricula[] = str_pad($anoRegistro, 4, '0', STR_PAD_LEFT);

        // Número do Livro (3 dígitos)
        $matricula[] = str_pad(random_int(1, 999), 3, '0', STR_PAD_LEFT);

        // Número da Folha (3 dígitos)
        $matricula[] = str_pad(random_int(1, 999), 3, '0', STR_PAD_LEFT);

        // Número do Termo (8 dígitos)
        $matricula[] = str_pad(random_int(1, 99999999), 8, '0', STR_PAD_LEFT);

        // Dígito Verificador (2 dígitos)
        $matricula[] = $this->calculateDigit(implode('', $matricula));

        return implode('', $matricula);
    }

    private function calculateDigit($base)
    {
        $sum = 0;
        $factor = 2;

        // Multiplica cada dígito da base pelo fator
        foreach (array_reverse(str_split($base)) as $digit) {
            $sum += $digit * $factor;
            $factor = $factor === 9 ? 2 : $factor + 1; // Reinicia o fator em 2 quando chega a 9
        }

        $remainder = $sum % 11;

        // Retorna 00 se o resto for 0 ou 1, caso contrário 11 - resto
        return str_pad(($remainder < 2 ? 0 : 11 - $remainder), 2, '0', STR_PAD_LEFT);
    }

    private function formatMatricula($matricula)
    {
        return substr($matricula, 0, 2) . '.' .
               substr($matricula, 2, 4) . '.' .
               substr($matricula, 6, 4) . '.' .
               substr($matricula, 10, 3) . '.' .
               substr($matricula, 13, 3) . '.' .
               substr($matricula, 16, 8) . '-' .
               substr($matricula, 24, 2);
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

        return $ufCodes[strtoupper($uf)] ?? str_pad(random_int(1, 27), 2, '0', STR_PAD_LEFT);
    }

    private function getRandomUf()
    {
        $ufs = ['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'];
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
