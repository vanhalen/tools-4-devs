<?php

namespace App\Services;

use App\Models\Cep;

class CepService
{
    protected $viaCepService;
    protected $brasilApiService;

    public function __construct(ViaCepService $viaCepService, BrasilApiService $brasilApiService)
    {
        $this->viaCepService = $viaCepService;
        $this->brasilApiService = $brasilApiService;
    }

    /**
     * Gera um endereço real válido com base nos parâmetros opcionais.
     *
     * @param string|null $uf
     * @param bool $formatted
     * @return array
     * @throws \Exception
     */
    public function gerarEndereco($uf = null, $formatted = true)
    {
        // Verifica se a UF está vazia ou é "null" explicitamente
        if (is_null($uf) || strtolower($uf) === 'null') {
            $uf = null; // Ou defina um comportamento padrão, como escolher uma UF aleatória
        }

        // Gera um CEP aleatório do banco
        $cepModel = $this->gerarCep($uf);
        if($cepModel instanceof Cep){
            return $this->formatarRetorno($cepModel, $formatted);
        }
        throw new \Exception("Não foi possível encontrar ou gerar o CEP.");
    }

    /**
     * Realiza a busca de um CEP.
     *
     * @param string $cep
     */
    public function buscarCep($cep)
    {
        // Remove formatação do CEP
        $cep = preg_replace('/[^0-9]/', '', $cep);

        // Valida o CEP (somente números e 8 dígitos)
        if (strlen($cep) !== 8) {
            throw new \Exception("CEP inválido. Certifique-se de que possui 8 dígitos.");
        }

        $atualizarQuery = false;

        // Busca o CEP no banco
        $query = Cep::query()->where('cep', $cep)->first();

        // Verifica se já foi consultado no ViaCep
        if (!$this->jaConsultado($query, 'consultado_viacep')) {
            $viaCepResult = $this->consultarViaCep($cep);
            if ($viaCepResult) {
                $atualizarQuery = true;
            }
        }

        // Atualiza a query caso tenha salvo no ViaCep
        if ($atualizarQuery) {
            $query = Cep::query()->where('cep', $cep)->first();
            $atualizarQuery = false; // Reseta para evitar confusão com BrasilAPI
        }


        // Verifica se já foi consultado na BrasilAPI
        if (!$this->jaConsultado($query, 'consultado_brasilapi')) {
            $brasilApiResult = $this->consultarBrasilApi($cep, $query);
            if ($brasilApiResult) {
                $atualizarQuery = true;
            }
        }

        // Atualiza a query novamente caso tenha salvo na BrasilAPI
        if ($atualizarQuery) {
            $query = Cep::query()->where('cep', $cep)->first();
        }

        if (!$query) {
            throw new \Exception("Nenhum CEP encontrado no banco de dados.");
        }

        return $this->formatarRetorno($query, true);
    }

    /**
     * Seleciona um CEP aleatório do banco de dados.
     *
     * @param string|null $uf
     * @return string
     */
    private function gerarCep($uf = null): Cep
    {
        $query = Cep::query();

        // Adiciona o filtro de UF, se fornecido
        if ($uf) {
            $query->where('uf', strtoupper($uf));
        }

        // Obtém o menor e maior ID para o filtro especificado (ou para toda a tabela, se nenhuma UF for passada)
        $ids = $query->selectRaw('MIN(id) AS min_id, MAX(id) AS max_id')->first();

        if (!$ids || !$ids->min_id || !$ids->max_id) {
            throw new \Exception("Nenhum CEP encontrado no banco de dados.");
        }

        // Gera um ID aleatório dentro do intervalo
        $randomId = random_int($ids->min_id, $ids->max_id);

        // Busca um CEP correspondente ao ID gerado
        $cepModel = Cep::where('id', '>=', $randomId);

        // Aplica o filtro de UF novamente, se necessário
        if ($uf) {
            $cepModel->where('uf', strtoupper($uf));
        }

        // Retorna o primeiro registro encontrado
        $cepModel = $cepModel->first();

        // Fallback: Caso o ID gerado não tenha correspondido, busca o primeiro registro disponível
        if (!$cepModel) {
            $cepModel = Cep::query();

            if ($uf) {
                $cepModel->where('uf', strtoupper($uf));
            }

            $cepModel = $cepModel->first();
        }

        if (!$cepModel) {
            throw new \Exception("Nenhum CEP encontrado no banco de dados.");
        }

        return $cepModel;
    }

    /**
     * Verifica se o CEP já foi consultado em uma fonte específica.
     *
     * @param Cep|null $query
     * @param string $campo
     * @return bool
     */
    private function jaConsultado($query, string $campo): bool
    {
        return $query && $query->{$campo};
    }

    private function consultarViaCep($cep)
    {
        try {
            $endereco = $this->viaCepService->buscarEnderecoPorCep($cep);
            if (!isset($endereco['erro'])) {
                // Salva somente se a API retornou dados válidos
                $this->salvar($cep, [
                    'logradouro' => $endereco['logradouro'],
                    'complemento' => $endereco['complemento'],
                    'unidade' => $endereco['unidade'],
                    'bairro' => $endereco['bairro'],
                    'localidade' => $endereco['localidade'],
                    'uf' => $endereco['uf'],
                    'estado' => $endereco['estado'],
                    'regiao' => $endereco['regiao'],
                    'ibge' => $endereco['ibge'],
                    'gia' => $endereco['gia'],
                    'ddd' => $endereco['ddd'],
                    'siafi' => $endereco['siafi'],
                    'consultado_viacep' => 1,
                ]);
                return true; // Indicando que foi salvo
            }
        } catch (\Exception $e) {
            // Log de erro ou tratativa adicional
        }
        return false; // Nada foi salvo
    }

    private function consultarBrasilApi($cep, $query)
    {
        try {
            $endereco = $this->brasilApiService->buscarEnderecoPorCep($cep);
            if (!isset($endereco['erro'])) {
                // Salva somente se a API retornou dados válidos
                $this->salvar($cep, [
                    'localizacao_tipo' => $endereco['location']['type'],
                    'localizacao_longitude' => $endereco['location']['coordinates']['longitude'],
                    'localizacao_latitude' => $endereco['location']['coordinates']['latitude'],
                    'consultado_brasilapi' => 1,
                ]);
                return true; // Indicando que foi salvo
            } elseif ($query) {
                // Marca como consultado apenas se o registro já existe
                $query->update(['consultado_brasilapi' => 1]);
            }
        } catch (\Exception $e) {
            // Log de erro ou tratativa adicional
            if ($query) {
                $query->update(['consultado_brasilapi' => 1]);
            }
        }
        return false; // Nada foi salvo
    }

    /**
     * Salva ou atualiza os dados do CEP no banco de dados sem sobrescrever campos não fornecidos.
     *
     * @param string $cep
     * @param array $dados
     * @return void
     */
    private function salvar(string $cep, array $dados): void
    {
        $cepModel = Cep::firstOrNew(['cep' => $cep]);

        foreach ($dados as $campo => $valor) {
            if ($valor !== null) {
                $cepModel->$campo = $valor;
            }
        }

        $cepModel->save();
    }


    /**
     * Formata os dados do CEP para retorno.
     *
     * @param Cep $cepModel
     * @param bool $formatted
     * @return array
     */
    private function formatarRetorno(Cep $cepModel, bool $formatted): array
    {
        $endereco = $cepModel->toArray();

        if ($formatted) {
            // Aplica a formatação ao CEP (#####-###)
            $endereco['cep'] = preg_replace('/^(\d{5})(\d{3})$/', '$1-$2', $endereco['cep']);
        }

        // Define os campos que você quer remover
        $camposIndesejados = ['id', 'consultado_viacep', 'consultado_brasilapi', 'created_at', 'updated_at'];

        // Remove os campos indesejados usando array_diff_key
        $endereco = array_diff_key($endereco, array_flip($camposIndesejados));

        return $endereco;
    }


}
