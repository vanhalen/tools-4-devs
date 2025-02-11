<?php

namespace App\Services;

class StringService
{
    /**
     * Analisa um texto e retorna diversas informações estatísticas.
     *
     * @param string $text O texto a ser analisado.
     * @return array Informações estatísticas do texto.
     */
    public function analyzeText(string $text): array
    {
        // Remove espaços para contagem de palavras e espaços
        $cleanText = trim(preg_replace('/\s+/', ' ', $text));

        // Contagens básicas
        $characterCount = mb_strlen($text);
        $characterCountNoSpaces = mb_strlen(str_replace(' ', '', $text));
        $wordCount = $cleanText === '' ? 0 : count(explode(' ', $cleanText));
        $spaceCount = substr_count($text, ' ');
        $lineCount = substr_count($text, "\n") + 1;

        // Contagem de vogais, consoantes e números
        $vowelCount = preg_match_all('/[aeiouáéíóúâêôãõàèìòùäëïöü]/iu', $text);
        $consonantCount = preg_match_all('/[bcdfghjklmnpqrstvwxyz]/iu', $text);
        $numberCount = preg_match_all('/\d/', $text);

        // Tempo médio de leitura (200 palavras por minuto)
        $readingTimeMinutes = $wordCount / 200;

        // Tempo médio de discurso (130 palavras por minuto)
        $speechTimeMinutes = $wordCount / 130;

        // Formata os tempos
        $readingTime = $this->formatTime($readingTimeMinutes);
        $speechTime = $this->formatTime($speechTimeMinutes);

        return [
            'caracteres' => $characterCount,
            'caracteres_sem_espacos' => $characterCountNoSpaces,
            'palavras' => $wordCount,
            'espacos' => $spaceCount,
            'linhas' => $lineCount,
            'vogais' => $vowelCount,
            'consoantes' => $consonantCount,
            'numeros' => $numberCount,
            'tempo_leitura' => $readingTime,
            'tempo_discurso' => $speechTime
        ];
    }

    /**
     * Formata o tempo em minutos e segundos.
     *
     * @param float $time O tempo em minutos.
     * @return string O tempo formatado como "Xm Ys".
     */
    private function formatTime(float $time): string
    {
        $minutes = floor($time);
        $seconds = ceil(($time - $minutes) * 60);
        return "{$minutes}m {$seconds}s";
    }


    ######

    /**
     * Converte o texto para diferentes formatos de maiúsculas/minúsculas.
     *
     * @param string $text
     * @param string $type
     * @return string
     * @throws \Exception
     */
    public function convertCase(string $text, string $type): string
    {
        switch (strtolower($type)) {
            case 'uppercase': // Tudo em maiúsculas
                return strtoupper($text);

            case 'lowercase': // Tudo em minúsculas
                return strtolower($text);

            case 'alternating': // Alternado ex: "Oi VoCê EsTá BeM?"
                return $this->toAlternatingCase($text);

            case 'capitalize_first_letter': // Primeira letra de cada palavra
                return ucwords(strtolower($text));

            case 'capitalize_first_sentence': // Primeira letra da frase
                return $this->capitalizeFirstSentence($text);

            default:
                throw new \Exception("Tipo de conversão inválido: {$type}. Tipos válidos: uppercase, lowercase, alternating, capitalize_first_letter, capitalize_first_sentence.");
        }
    }

    /**
     * Converte o texto para o formato alternado ex: "Oi VoCê EsTá BeM?"
     *
     * @param string $text
     * @return string
     */
    private function toAlternatingCase(string $text): string
    {
        $result = '';
        $toggle = true;

        foreach (str_split($text) as $char) {
            if (ctype_alpha($char)) {
                $result .= $toggle ? strtoupper($char) : strtolower($char);
                $toggle = !$toggle;
            } else {
                $result .= $char;
            }
        }

        return $result;
    }

    /**
     * Converte a primeira letra da frase em maiúsculo.
     *
     * @param string $text
     * @return string
     */
    private function capitalizeFirstSentence(string $text): string
    {
        $sentences = preg_split('/([.!?]\s*)/', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
        for ($i = 0; $i < count($sentences); $i += 2) {
            $sentences[$i] = ucfirst(strtolower($sentences[$i]));
        }
        return implode('', $sentences);
    }

}
