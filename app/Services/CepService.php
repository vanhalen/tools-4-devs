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
     * Consulta APIs externas para obter informações de um CEP.
     *
     * @param string $cep
     * @return array|null
     */
    private function consultarApisExternas(string $cep): ?array
    {
        try {
            $endereco = $this->viaCepService->buscarEnderecoPorCep($cep);
            if (!isset($endereco['erro'])) {
                return $endereco;
            }
        } catch (\Exception $e) {
            // Log de erro para ViaCEP
        }

        try {
            $endereco = $this->brasilApiService->buscarEnderecoPorCep($cep);
            if (!isset($endereco['erro'])) {
                return $endereco;
            }
        } catch (\Exception $e) {
            // Log de erro para BrasilAPI
        }

        return null;
    }

    /**
     * Salva os dados do CEP no banco de dados.
     *
     * @param string $cep
     * @param array $dados
     * @return void
     */
    private function salvarCepNoBanco(string $cep, array $dados): void
    {
        Cep::create([
            'cep' => $cep,
            'logradouro' => $dados['logradouro'] ?? null,
            'complemento' => $dados['complemento'] ?? null,
            'bairro' => $dados['bairro'] ?? null,
            'localidade' => $dados['localidade'] ?? null,
            'uf' => $dados['uf'] ?? null,
            'estado' => $dados['estado'] ?? null,
            'regiao' => $dados['regiao'] ?? null,
            'ibge' => $dados['ibge'] ?? null,
            'gia' => $dados['gia'] ?? null,
            'ddd' => $dados['ddd'] ?? null,
            'siafi' => $dados['siafi'] ?? null,
            'consultado_viacep' => isset($dados['viacep']) ? 1 : 0,
            'consultado_brasilapi' => isset($dados['brasilapi']) ? 1 : 0,
        ]);
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
