<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use App\Services\CpfService;
use App\Services\CnpjService;
use App\Services\RgService;
use App\Services\TituloEleitorService;
use App\Services\PisPasepService;
use Illuminate\Http\Request;

class ValidatorController extends Controller
{
    use ApiResponser;
    protected $cpfService;
    protected $cnpjService;
    protected $rgService;
    protected $tituloEleitorService;
    protected $pisPasepService;

    public function __construct(
        CpfService $cpfService,
        CnpjService $cnpjService,
        RgService $rgService,
        TituloEleitorService $tituloEleitorService,
        PisPasepService $pisPasepService,
    )
    {
        $this->cpfService = $cpfService;
        $this->cnpjService = $cnpjService;
        $this->rgService = $rgService;
        $this->tituloEleitorService = $tituloEleitorService;
        $this->pisPasepService = $pisPasepService;
    }

    /**
     * Valida um CPF.
     */
    public function cpf(Request $request)
    {
        try {
            return $this->successResponseValidate($request, 'cpf', $this->cpfService);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Valida um CNPJ.
     */
    public function cnpj(Request $request)
    {
        try {
            return $this->successResponseValidate($request, 'cnpj', $this->cnpjService);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Valida um RG.
     */
    public function rg(Request $request) {
        try {
            return $this->successResponseValidate($request, 'rg', $this->rgService);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Valida um Título de Eleitor.
     */
    public function tituloEleitor(Request $request) {
        try {
            return $this->successResponseValidate($request, 'titulo', $this->tituloEleitorService);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Valida um PIS/PASEP.
     */
    public function pisPasep(Request $request) {
        try {
            return $this->successResponseValidate($request, 'pispasep', $this->pisPasepService);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

}
