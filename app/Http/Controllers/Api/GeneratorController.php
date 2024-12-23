<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use App\Services\CpfService;
use App\Services\RgService;
use App\Services\CnpjService;
use App\Services\TituloEleitorService;
use App\Services\PisPasepService;
use App\Services\CertidaoService;
use App\Services\SenhaService;
use App\Services\CepService;
use App\Services\LoremIpsumService;
use Illuminate\Http\Request;

/**
 * Responsável pela geração de dados
 */
class GeneratorController extends Controller
{
    use ApiResponser;
    protected $cpfService;
    protected $rgService;
    protected $cnpjService;
    protected $tituloEleitorService;
    protected $pisPasepService;
    protected $certidaoService;
    protected $senhaService;
    protected $cepService;
    protected $loremIpsumService;

    public function __construct(
        CpfService $cpfService,
        RgService $rgService,
        CnpjService $cnpjService,
        TituloEleitorService $tituloEleitor,
        PisPasepService $pisPasep,
        CertidaoService $certidao,
        SenhaService $senha,
        CepService $cep,
        LoremIpsumService $loremIpsum,
    ){
        $this->cpfService = $cpfService;
        $this->rgService = $rgService;
        $this->cnpjService = $cnpjService;
        $this->tituloEleitorService = $tituloEleitor;
        $this->pisPasepService = $pisPasep;
        $this->certidaoService = $certidao;
        $this->senhaService = $senha;
        $this->cepService = $cep;
        $this->loremIpsumService = $loremIpsum;
    }

    /**
     * Gera um CPF válido.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cpf(Request $request) {
        try {
            // Captura os parâmetros opcionais
            $formatted = filter_var($request->query('formatted', true), FILTER_VALIDATE_BOOLEAN);
            $uf = $request->query('uf', null);

            // Gera o CPF
            $cpf = $this->cpfService->generate($formatted, $uf);

            return $this->successResponse(['cpf' => $cpf]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Gera um RG válido.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function rg(Request $request) {
        try {
            // Captura o parâmetro opcional
            $formatted = filter_var($request->query('formatted', true), FILTER_VALIDATE_BOOLEAN);

            // Gera o RG
            $rg = $this->rgService->generate($formatted);

            return $this->successResponse(['rg' => $rg]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Gera um CNPJ válido.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cnpj(Request $request) {
        try {
            // Captura o parâmetro opcional
            $formatted = filter_var($request->query('formatted', true), FILTER_VALIDATE_BOOLEAN);

            // Gera o CNPJ
            $cnpj = $this->cnpjService->generate($formatted);

            return $this->successResponse(['cnpj' => $cnpj]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }


    /**
     * Gera um Título de Eleitor válido.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function tituloEleitor(Request $request) {
        try {
            // Captura os parâmetros opcionais
            $formatted = filter_var($request->query('formatted', true), FILTER_VALIDATE_BOOLEAN);
            $uf = $request->query('uf', null);

            // Gera o CPF
            $tituloEleitor = $this->tituloEleitorService->generate($formatted, $uf);

            return $this->successResponse(['tituloEleitor' => $tituloEleitor]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Gera um PIS/PASEP válido.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function pisPasep(Request $request) {
        try {
            // Captura o parâmetro opcional
            $formatted = filter_var($request->query('formatted', true), FILTER_VALIDATE_BOOLEAN);

            // Gera o PIS/PASEP
            $pispasep = $this->pisPasepService->generate($formatted);

            return $this->successResponse(['pispasep' => $pispasep]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Gera uma certidão válida.
     *
     * @param string $type
     * @param string|null $uf
     * @param int|null $year
     * @param int|null $notary
     * @param bool $formatted
     * @return \Illuminate\Http\JsonResponse
     */
    public function certidao(Request $request) {
        try {
            // Captura os parâmetros opcionais
            $tipo = $request->query('type', 'nascimento');
            $uf = $request->query('uf', null);
            $anoRegistro = $request->query('year', null);
            $codigoCartorio = $request->query('notary', null);
            $formatted = filter_var($request->query('formatted', true), FILTER_VALIDATE_BOOLEAN);

            // Gera o número da certidão
            $certidao = $this->certidaoService->generate($tipo, $uf, $anoRegistro, $codigoCartorio, $formatted);

            return $this->successResponse(['certidao' => $certidao, 'tipo' => $tipo]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Gera uma senha com base nos parâmetros fornecidos.
     *
     * @param int $length
     * @param bool $uppercase
     * @param bool $lowercase
     * @param bool $numbers
     * @param bool $specials
     * @return string
     * @throws \Exception
     */
    public function senha(Request $request) {
        try {
            // Captura os parâmetros opcionais
            $tamanho = (int) $request->query('length', 6);
            $maiusculas = filter_var($request->query('uppercase', true), FILTER_VALIDATE_BOOLEAN);
            $minusculas = filter_var($request->query('lowercase', true), FILTER_VALIDATE_BOOLEAN);
            $numeros = filter_var($request->query('numbers', true), FILTER_VALIDATE_BOOLEAN);
            $especiais = filter_var($request->query('specials', true), FILTER_VALIDATE_BOOLEAN);

            // Gera a senha
            $senha = $this->senhaService->generate($tamanho, $maiusculas, $minusculas, $numeros, $especiais);

            return $this->successResponse(['senha' => $senha]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Gera uma endereço válido.
     *
     * @param string|null $uf
     * @param bool $formatted (Define se o CEP será formatado)
     * @return string
     * @throws \Exception
     */
    public function endereco(Request $request) {
        try {
            // Captura os parâmetros opcionais
            $uf = $request->query('uf', null);
            $formatted = filter_var($request->query('formatted', true), FILTER_VALIDATE_BOOLEAN);

            // Gera o endereço
            $endereco = $this->cepService->gerarEndereco($uf, $formatted);

            return $this->successResponse(['endereco' => $endereco]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Gera um Lorem Ipsum (Gerador de texto).
     *
     * @return string
     * @throws \Exception
     */
    public function LoremIpsum(Request $request) {
        try {
            // Captura os parâmetros opcionais
            $tamanho = (int) $request->query('length', 5);
            $tipo = $request->query('type', 'paragrafos');
            $formato = $request->query('format', 'texto');


            // Gera o Lorem Ipsum
            $loremIpsum = $this->loremIpsumService->generate($tamanho, $tipo, $formato);

            return $this->successResponse(['lorem' => $loremIpsum]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
