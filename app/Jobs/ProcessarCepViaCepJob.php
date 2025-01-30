<?php

namespace App\Jobs;

use App\Models\Cep;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessarCepViaCepJob implements ShouldQueue
{
    use Dispatchable;

    public function handle()
    {
        // Buscar registros que ainda não foram consultados no ViaCEP
        $ceps = Cep::where('consultado_viacep', false)
            ->take(200000) // Processar 200.000 registros por vez
            ->get();

        foreach ($ceps as $cep) {
            try {
                // Requisição para ViaCEP usando o proxy Tor (SOCKS5)
                $response = Http::withOptions([
                    'proxy' => 'socks5h://127.0.0.1:9050', // Proxy do Tor
                ])->get("https://viacep.com.br/ws/{$cep->cep}/json/");

                if ($response->successful() && !isset($response['erro'])) {
                    $dados = $response->json();

                    // Atualizar os campos no banco
                    $cep->logradouro = $dados['logradouro'] ?? $cep->logradouro;
                    $cep->complemento = $dados['complemento'] ?? $cep->complemento;
                    $cep->unidade = $dados['unidade'] ?? $cep->unidade;
                    $cep->bairro = $dados['bairro'] ?? $cep->bairro;
                    $cep->localidade = $dados['localidade'] ?? $cep->localidade;
                    $cep->uf = $dados['uf'] ?? $cep->uf;
                    $cep->estado = $dados['estado'] ?? $cep->estado;
                    $cep->regiao = $dados['regiao'] ?? $cep->regiao;
                    $cep->ibge = $dados['ibge'] ?? $cep->ibge;
                    $cep->gia = $dados['gia'] ?? $cep->gia;
                    $cep->ddd = $dados['ddd'] ?? $cep->ddd;
                    $cep->siafi = $dados['siafi'] ?? $cep->siafi;
                    $cep->consultado_viacep = true;
                    $cep->save();

                    Log::info("ViaCEP {$cep->cep} consultado e atualizado com sucesso.");
                } else {
                    Log::warning("CEP {$cep->cep} não encontrado no ViaCEP.");
                    $cep->consultado_viacep = true;
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
