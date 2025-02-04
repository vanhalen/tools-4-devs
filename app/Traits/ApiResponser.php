<?php

namespace App\Traits;

trait ApiResponser
{
    /**
     * Resposta de sucesso.
     *
     * @param array $data
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse(array $data, int $statusCode = 200)
    {
        return response()->json(array_merge(['status' => true], $data), $statusCode);
    }

    /**
     * Resposta de erro.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse(string $message, int $statusCode = 400)
    {
        return response()->json([
            'status' => false,
            'errors' => [
                'message' => $message,
            ],
        ], $statusCode);
    }

    protected function successResponseValidate($request, $arg, $service){
        $req = $request->query($arg);
        if (!$req) return $this->errorResponse(strtoupper($arg).' é obrigatório.');

        $isValid = $service->validate($req);

        if($arg === 'titulo') {
            $uf = $service->getUf($req);
            return $this->successResponse([$arg => $req, 'uf' => $uf, 'is_valid' => $isValid]);
        }
        if($arg === 'certidao'){
            return $this->successResponse([
                $arg => $req,
                'is_valid' => $isValid['is_valid'],
                'tipo' => $isValid['tipo'],
                'uf' => $isValid['uf'],
                'ano' => $isValid['ano'],
                'cod_cartorio' => $isValid['cod_cartorio']
        ]);
        }

        return $this->successResponse([$arg => $req, 'is_valid' => $isValid]);
    }
}
