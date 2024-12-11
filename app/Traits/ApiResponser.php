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
        return response()->json([
            'status' => true,
            'data' => $data,
        ], $statusCode);
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
}
