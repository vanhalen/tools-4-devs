<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class NetworkController extends Controller
{

    use ApiResponser;

    /**
     * Retorna os IPs do usuário que está acessando a API.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getIp(Request $request)
    {
        $ipv4 = $this->getIpByType($request, FILTER_FLAG_IPV4);
        $ipv6 = $this->getIpByType($request, FILTER_FLAG_IPV6);

        return $this->successResponse([
            'ipv4' => $ipv4,
            'ipv6' => $ipv6
        ]);
    }

    private function getIpByType(Request $request, int $filter)
    {
        $headers = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR',
        ];

        foreach ($headers as $header) {
            if ($request->server($header)) {
                $ips = explode(',', $request->server($header));
                foreach ($ips as $ip) {
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, $filter)) {
                        return $ip;
                    }
                }
            }
        }

        // Como último recurso, usa o IP direto
        $userIp = $request->ip();
        return filter_var($userIp, FILTER_VALIDATE_IP, $filter) ? $userIp : null;
    }

    /**
     * Retorna o IP do usuário por uma API externa.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getIpExternalApi(Request $request)
    {
        // Tenta capturar o IP enviado pelo cabeçalho
        $userPublicIp = $request->header('X-User-IP') ?? false;

        // Captura o IP público e informações do provedor
        $publicIpData = $this->getPublicIpData($userPublicIp);

        return $this->successResponse([
            'local_ip' => $request->ip(),
            'public_ip' => $publicIpData['ip'] ?? null,
            'hostname' => $publicIpData['hostname'] ?? null,
            'provider' => $publicIpData['org'] ?? null,
            'city' => $publicIpData['city'] ?? null,
            'region' => $publicIpData['region'] ?? null,
            'country' => $publicIpData['country'] ?? null,
            'timezone' => $publicIpData['timezone'] ?? null,
            'loc' => $publicIpData['loc'] ?? null,
        ]);
    }

    /**
     * Obtém o IP público utilizando uma API externa.
     *
     * @return string|null
     */
    private function getPublicIpData($ip)
    {
        try {
            $response = file_get_contents($ip ? "https://ipinfo.io/{$ip}/json" : "https://ipinfo.io/json");
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

        return $this->successResponse([
            'browser' => $browser,
            'version' => $version,
        ]);
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

        return $this->successResponse([
            'system' => $platform,
            'version' => $version,
        ]);
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

            return $this->successResponse([
                'ip' => $ip,
                'is_valid' => true,
                'is_public' => !$isPrivate
            ]);
        }

        return $this->errorResponse('IP inválido');
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
            return $this->errorResponse('Nenhum domínio ou IP fornecido.');
        }

        // Tenta resolver o DNS
        try {
            $resolvedIp = gethostbyname($host); // Resolve o IP do domínio
            $resolvedHost = @gethostbyaddr($resolvedIp); // Resolve o host reverso usando o IP

            return $this->successResponse([
                'host' => $host,
                'resolved_ip' => $resolvedIp,
                'resolved_host' => $resolvedHost ?: 'Não disponível',
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse('Erro ao resolver o DNS: ' . $e->getMessage());
        }
    }

    /**
     * Testa se uma porta está aberta em um IP ou domínio.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function portTest(Request $request)
    {
        $host = $request->query('host');
        $port = (int) $request->query('port');

        if (!$host || !$port) {
            return $this->errorResponse('Host e porta são obrigatórios.');
        }

        // Testa a porta
        try {
            $connection = @fsockopen($host, $port, $errno, $errstr, 5); // Timeout de 5 segundos
            if ($connection) {
                fclose($connection);
                return $this->successResponse([
                    'host' => $host,
                    'port' => $port,
                    'is_open' => true
                ]);
            } else {
                return $this->successResponse([
                    'host' => $host,
                    'port' => $port,
                    'is_open' => false
                ]);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Erro ao testar a porta: ' . $e->getMessage());
        }
    }
}
