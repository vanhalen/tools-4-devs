<?php

namespace App\Services;

class SenhaService
{
    /**
     * Gera uma senha com base nos parâmetros fornecidos.
     *
     * @param int $tamanho
     * @param bool $maiusculas
     * @param bool $minusculas
     * @param bool $numeros
     * @param bool $especiais
     * @return string
     * @throws \Exception
     */
    public function generate($length = 6, $uppercase = true, $lowercase = true, $numbers = true, $specials = true) {
        // Valida o tamanho mínimo da senha
        if ($length < 1) {
            throw new \Exception("O tamanho da senha deve ser no mínimo 1.");
        }

        // Define os caracteres permitidos com base nos parâmetros
        $allCharacters = '';
        $mandatoryCharacters = '';

        if ($uppercase) {
            $uppercaseChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $allCharacters .= $uppercaseChars;
            $mandatoryCharacters .= $uppercaseChars[random_int(0, strlen($uppercaseChars) - 1)];
        }

        if ($lowercase) {
            $lowercaseChars = 'abcdefghijklmnopqrstuvwxyz';
            $allCharacters .= $lowercaseChars;
            $mandatoryCharacters .= $lowercaseChars[random_int(0, strlen($lowercaseChars) - 1)];
        }

        if ($numbers) {
            $numberChars = '0123456789';
            $allCharacters .= $numberChars;
            $mandatoryCharacters .= $numberChars[random_int(0, strlen($numberChars) - 1)];
        }

        if ($specials) {
            $specialChars = '!@#$%^&*()-_=+[]{}<>?/|';
            $allCharacters .= $specialChars;
            $mandatoryCharacters .= $specialChars[random_int(0, strlen($specialChars) - 1)];
        }

        // Verifica se há caracteres disponíveis
        if (empty($allCharacters)) {
            throw new \Exception("Pelo menos um tipo de caractere deve ser selecionado.");
        }

        // Calcula o restante dos caracteres aleatórios para completar o tamanho da senha
        $remainingLength = $length - strlen($mandatoryCharacters);
        $password = $mandatoryCharacters;

        for ($i = 0; $i < $remainingLength; $i++) {
            $password .= $allCharacters[random_int(0, strlen($allCharacters) - 1)];
        }

        // Embaralha a senha para distribuir os caracteres obrigatórios de forma aleatória
        return str_shuffle($password);
    }

}
