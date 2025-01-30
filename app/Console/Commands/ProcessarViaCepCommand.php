<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ProcessarCepViaCepJob;

class ProcessarViaCepCommand extends Command
{
    /**
     * O nome e descrição do comando.
     */
    protected $signature = 'processar:viacep';

    protected $description = 'Processa os CEPs para consultar o ViaCEP e salvar no banco.';

    /**
     * Execute o comando.
     */
    public function handle()
    {
        // Enfileirar o Job
        ProcessarCepViaCepJob::dispatch();

        $this->info("Job de processamento dos CEPs foi enviado para a fila.");
    }
}
