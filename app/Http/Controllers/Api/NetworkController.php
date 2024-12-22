<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class NetworkController extends Controller
{
    /**
     * Retorna o IP do usuário.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getIp(Request $request)
    {
        // Captura o IP local
        $localIp = $request->ip();

        // Captura o IP público e informações do provedor
        $publicIpData = $this->getPublicIpData();

        return response()->json([
            'status' => true,
            'data' => [
                'local_ip' => $localIp,
                'public_ip' => $publicIpData['ip'] ?? null,
                'hostname' => $publicIpData['hostname'] ?? null,
                'provider' => $publicIpData['org'] ?? null,
                'city' => $publicIpData['city'] ?? null,
                'region' => $publicIpData['region'] ?? null,
                'country' => $publicIpData['country'] ?? null,
                'timezone' => $publicIpData['timezone'] ?? null,
                'loc' => $publicIpData['loc'] ?? null,
            ]
        ], 200);
    }

    /**
     * Obtém o IP público utilizando uma API externa.
     *
     * @return string|null
     */
    private function getPublicIpData()
    {
        try {
            $response = file_get_contents('https://ipinfo.io/json');
            $data = json_decode($response, true);

            return $data;
        } catch (\Exception $e) {
            $response2 = file_get_contents('https://api.ipify.org?format=json');
            $data = json_decode($response2, true);

            return $data;
        }
    }

    /**
     * Retorna o navegador do usuário.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBrowser(Request $request)
    {
        $agent = new Agent();
        $browser = $agent->browser();
        $version = $agent->version($browser);

        return response()->json([
            'status' => true,
            'data' => [
                'browser' => $browser,
                'version' => $version,
            ]
        ], 200);
    }

    /**
     * Retorna o sistema operacional do usuário.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSystem(Request $request)
    {
        $agent = new Agent();
        $platform = $agent->platform();
        $version = $agent->version($platform);

        return response()->json([
            'status' => true,
            'data' => [
                'system' => $platform,
                'version' => $version,
            ]
        ], 200);
    }

    /**
     * Valida um IP informado.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateIp(Request $request)
    {
        $ip = $request->query('ip');

        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            $isPrivate = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) ? false : true;
            return response()->json([
                'status' => true,
                'data' => [
                    'ip' => $ip,
                    'is_valid' => true,
                    'is_public' => !$isPrivate
                ]
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'IP inválido.'
        ], 400);
    }

    /**
     * Resolve um domínio para IP e vice-versa.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resolveDns(Request $request)
    {
        $host = $request->query('host');

        if (!$host) {
            return response()->json([
                'status' => false,
                'message' => 'Nenhum domínio ou IP fornecido.'
            ], 400);
        }

        // Tenta resolver o DNS
        try {
            $resolvedIp = gethostbyname($host); // Resolve o IP do domínio
            $resolvedHost = @gethostbyaddr($resolvedIp); // Resolve o host reverso usando o IP

            return response()->json([
                'status' => true,
                'data' => [
                    'host' => $host,
                    'resolved_ip' => $resolvedIp,
                    'resolved_host' => $resolvedHost ?: 'Não disponível',
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao resolver o DNS: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Testa se uma porta está aberta em um IP ou domínio.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function testPort(Request $request)
    {
        $host = $request->query('host');
        $port = (int) $request->query('port');

        if (!$host || !$port) {
            return response()->json([
                'status' => false,
                'message' => 'Host e porta são obrigatórios.'
            ], 400);
        }

        // Testa a porta
        try {
            $connection = @fsockopen($host, $port, $errno, $errstr, 5); // Timeout de 5 segundos
            if ($connection) {
                fclose($connection);
                return response()->json([
                    'status' => true,
                    'data' => [
                        'host' => $host,
                        'port' => $port,
                        'is_open' => true
                    ]
                ], 200);
            } else {
                return response()->json([
                    'status' => true,
                    'data' => [
                        'host' => $host,
                        'port' => $port,
                        'is_open' => false
                    ]
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao testar a porta: ' . $e->getMessage()
            ], 500);
        }
    }
}