<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ProcessarCepBrasilApiJob;

class ProcessarBrasilApiCommand extends Command
{
    /**
     * O nome e descrição do comando.
     */
    protected $signature = 'processar:brasilapi';

    protected $description = 'Processa os CEPs para consultar o BrasilApi e salvar no banco.';

    /**
     * Execute o comando.
     */
    public function handle()
    {
        // Enfileirar o Job
        ProcessarCepBrasilApiJob::dispatch();

        $this->info("Job de processamento dos CEPs foi enviado para a fila.");
    }
}
