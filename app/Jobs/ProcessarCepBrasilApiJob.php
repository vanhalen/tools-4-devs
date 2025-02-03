<?php

namespace App\Jobs;

use App\Models\Cep;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessarCepBrasilApiJob implements ShouldQueue
{
    use Dispatchable;

    public function handle()
    {
        // Buscar registros que ainda não foram consultados no BrasilApi
        $ceps = Cep::where('consultado_brasilapi', false)
            ->take(200000) // Processar 200.000 registros
            ->get();

        foreach ($ceps as $cep) {
            try {
                // Requisição para BrasilApi usando o proxy Tor (SOCKS5)
                $response = Http::withOptions([
                    'proxy' => 'socks5h://127.0.0.1:9050', // Proxy do Tor
                ])->get("https://brasilapi.com.br/api/cep/v2/{$cep->cep}");

                if ($response->successful()) {
                    $dados = $response->json();

                    // Atualizar os campos no banco
                    $cep->localizacao_tipo = $dados['location']['type'] ?? $cep->localizacao_tipo;
                    $cep->localizacao_longitude = $dados['location']['coordinates']['longitude'] ?? $cep->localizacao_longitude;
                    $cep->localizacao_latitude = $dados['location']['coordinates']['latitude'] ?? $cep->localizacao_latitude;
                    $cep->consultado_brasilapi = true;
                    $cep->save();

                    Log::info("BrasilAPI {$cep->cep} consultado e atualizado com sucesso.");
                } else {
                    Log::warning("CEP {$cep->cep} não encontrado no BrasilApi.");
                    $cep->consultado_brasilapi = true;
                    $cep->save();
                }

                usleep(500000); // Atraso de 0.5 segundos
            } catch (\Exception $e) {
                Log::error("Erro ao consultar o CEP {$cep->cep}: {$e->getMessage()}");
            }

            gc_collect_cycles();
            gc_mem_caches();
            // Delay entre requisições
            sleep(0.5);
        }
    }
}
