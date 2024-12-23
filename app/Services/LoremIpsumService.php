<?php

namespace App\Services;

class LoremIpsumService
{
    /**
     * Gera texto Lorem Ipsum com base nos parâmetros fornecidos.
     *
     * @param int $quantidade Número de parágrafos ou palavras. Padrão: 5.
     * @param string $tipo Tipo de texto a ser gerado: "paragrafos" ou "palavras". Padrão: "paragrafos".
     * @param string $formato Formato do retorno: "texto" ou "html". Padrão: "texto".
     * @return string Texto gerado no formato especificado.
     * @throws \Exception
     */
    public function generate(int $quantidade = 5, string $tipo = 'paragrafos', string $formato = 'texto'): string
    {
        $tipo = strtolower($tipo);
        $formato = strtolower($formato);


            $maxQuantidade = ($tipo === 'paragrafos') ? 2000 : 100000;
            if ($quantidade > $maxQuantidade) {
                throw new \Exception("O número máximo permitido é {$maxQuantidade}.");
            }

        // Texto base para geração
        $loremBase = [
            "Lorem ipsum dolor sit amet, consectetur adipiscing elit",
            "Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua",
            "Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris",
            "Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore",
            "Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt",
            "Autem sit saepe expedita ducimus fugiat magni incidunt voluptate asperiores",
            "Non, fugiat nulla pariatur. Laudantium repellat tenetur eum iste corrupti",
            "Voluptas similique, laudantium repellat tenetur odit magni incidunt voluptate",
            "Eum iste corrupti odit non fugiat nulla pariatur, non proident culpa",
            "Asperiores ipsam cupiditate voluptas similique, laudantium repellat tenetur eum",
            "Congue dapibus risus conubia elit turpis velit taciti dictum faucibus morbi ante scelerisque et, vitae inceptos augue quam potenti cubilia torquent egestas urna neque consequat. Semper et conubia praesent taciti mi, nec mattis dis sem tempus diam, aenean morbi ante vivamus",
            "Magna semper odio velit fusce tempus lobortis mollis eleifend eros maecenas scelerisque torquent mattis vivamus commodo",
            "Lectus posuere scelerisque inceptos ridiculus fames fermentum imperdiet pharetra taciti eleifend maximus, aliquet conubia feugiat ornare suspendisse nulla ultrices sociosqu vel litora, quisque tortor vulputate aenean dictum et senectus consequat porttitor arcu",
            "Fusce cursus pharetra aenean commodo sed fermentum magnis sodales finibus senectus, dictumst gravida nec tempus elit habitasse sapien est bibendum nullam, scelerisque ut class amet dolor himenaeos accumsan conubia elementum",
            "Tempor volutpat ipsum felis aptent arcu fusce aliquet urna nullam porta amet, vivamus mi litora turpis dictumst fringilla est pretium auctor nisl egestas sollicitudin, massa sagittis mus feugiat finibus fermentum consectetur pellentesque diam proin",
            "Eu taciti amet maximus lacus felis natoque habitant facilisi ex",
            "Ultrices purus nunc suscipit duis donec penatibus",
            "Vehicula velit praesent consequat cras imperdiet quis",
            "Natoque ante dolor dignissim laoreet",
            "Consequat natoque euismod aenean risus ipsum placerat",
            "Litora sociosqu ridiculus congue nisi facilisi molestie etiam, laoreet auctor tellus tempor proin vivamus tempus amet, iaculis vitae consequat sapien suspendisse metus. Odio dictumst et aenean porta diam nisl laoreet orci rutrum, eros blandit mi ultrices sociosqu vehicula fermentum",
            "Leo eu felis varius pulvinar magnis mollis urna, nisi penatibus consectetur vitae conubia facilisis sit per, parturient porta dictumst sed maecenas posuere duis, vel tristique purus ad habitasse et. Imperdiet fames netus primis sodales cursus placerat finibus potenti faucibus, tortor id tellus donec ad semper duis praesent, fermentum felis porttitor nisi fusce accumsan quis scelerisque. Pulvinar scelerisque turpis viverra dictum ante quis mollis luctus a sit cubilia curabitur tempor fusce, hendrerit ridiculus efficitur in auctor sodales ex congue aptent eleifend pellentesque ipsum. Sit vitae lacus habitant primis phasellus enim vehicula, felis eu id nisl rutrum nec quis, mauris penatibus finibus donec congue taciti. Curabitur sit metus risus facilisi tempus senectus mattis purus cursus, morbi turpis vitae eleifend vulputate faucibus cubilia vehicula pulvinar, ridiculus pharetra mollis imperdiet ad sollicitudin massa consequat. Maecenas vestibulum porttitor rhoncus risus nostra feugiat quisque congue dolor, molestie suspendisse arcu primis vehicula ipsum ridiculus dis. Dolor ut class tempus pellentesque pharetra laoreet finibus integer, senectus felis fermentum natoque eu quisque porta lacus, efficitur nullam justo mauris odio tristique id. Semper velit conubia integer adipiscing enim lectus justo donec amet, fringilla mus porttitor vivamus porta volutpat nullam eu ornare cras, odio nibh eget morbi primis accumsan dui finibus",
            "Aliquet vitae auctor molestie facilisis habitasse at metus erat",
            "Quam vivamus inceptos scelerisque turpis est aptent eleifend pretium eu magnis, orci posuere per vitae sed sit class nibh porttitor arcu luctus",
            "Pretium congue ultrices tempus bibendum taciti ornare ac nascetur penatibus",
            "Eros suscipit in metus ante placerat mus scelerisque finibus, ligula pellentesque per efficitur odio blandit molestie dictumst dui, cras nunc consequat turpis nascetur venenatis sed",
            "Porta accumsan pharetra per congue vulputate potenti morbi",
            "Venenatis torquent porttitor ante cubilia pulvinar turpis elementum, feugiat convallis vehicula orci pharetra lorem fames mauris",
            "Taciti sollicitudin curabitur leo varius velit aptent proin eros tellus, sodales phasellus ultrices class ultricies ridiculus augue cubilia, nec nam imperdiet lorem congue diam sed pretium",
        ];

        // Validar tipo
        if (!in_array($tipo, ['paragrafos', 'palavras'])) {
            throw new \Exception("Tipo inválido. Use 'paragrafos' ou 'palavras'.");
        }

        // Validar formato
        if (!in_array($formato, ['texto', 'html'])) {
            throw new \Exception("Formato inválido. Use 'texto' ou 'html'.");
        }

        // Gerar texto baseado no tipo
        $textoGerado = '';

        if ($tipo === 'paragrafos') {
            for ($i = 0; $i < $quantidade; $i++) {
                // Seleciona 3 a 5 frases aleatórias para cada parágrafo
                $paragrafo = implode(' ', $this->gerarFrasesAleatorias($loremBase, rand(3, 5)));
                if ($formato === 'html') {
                    $textoGerado .= "<p>{$paragrafo}.</p>";
                } else {
                    $textoGerado .= $paragrafo . ".\n\n";
                }
            }
        } elseif ($tipo === 'palavras') {
            $palavras = [];
            while (count($palavras) < $quantidade) {
                $todasPalavras = explode(' ', implode(' ', $loremBase));
                shuffle($todasPalavras); // Embaralha o conjunto atual
                $palavras = array_merge($palavras, $todasPalavras);
            }
            $palavras = array_slice($palavras, 0, $quantidade); // Corta exatamente a quantidade necessária

            $textoGerado = $this->capitalizarPrimeiraLetra(implode(' ', $palavras));
            if ($quantidade >= 2) {
                $textoGerado = $this->adicionarPontuacaoFinal($textoGerado);
            }
            if ($formato === 'html') {
                $textoGerado = "<p>{$textoGerado}</p>";
            }
        }

        return trim($textoGerado);
    }


    /**
     * Gera frases aleatórias a partir do texto base.
     *
     * @param array $frasesBase Array de frases disponíveis.
     * @param int $quantidade Número de frases a serem retornadas.
     * @return array Frases selecionadas aleatoriamente.
     */
    private function gerarFrasesAleatorias(array $frasesBase, int $quantidade): array
    {
        shuffle($frasesBase); // Embaralha as frases
        return array_slice($frasesBase, 0, $quantidade);
    }

    /**
     * Capitaliza a primeira letra de um texto.
     *
     * @param string $texto Texto a ser capitalizado.
     * @return string Texto com a primeira letra maiúscula.
     */
    private function capitalizarPrimeiraLetra(string $texto): string
    {
        return ucfirst($texto);
    }

    /**
     * Adiciona pontuação final aleatória (. ? !).
     *
     * @return string Pontuação final aleatória.
     */
    private function adicionarPontuacaoFinal(string $texto): string
    {
        $pontuacoesFinais = ['.', '?', '!']; // Pontuações finais permitidas

        // Remove quaisquer pontuações inválidas no final
        $texto = rtrim($texto, ',.?!'); // Remove vírgula, ponto, interrogação ou exclamação no final

        // Adiciona uma pontuação final válida
        return $texto . $pontuacoesFinais[array_rand($pontuacoesFinais)];
    }
}
