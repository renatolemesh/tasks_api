<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CrawMenorPreco extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawler:menor-preco {--categoria=?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando responsável por coletar dados da API do Menor Preço';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $categoria = $this->option('categoria')?? 1;

        $url = "https://menorpreco.notaparana.pr.gov.br/api/v1/produtos?local=6gkzqf9vb&categoria={$categoria}&offset=0&raio=500&data=-1&ordem=2";

        $http = Http::get($url);

        $response = $http->json('produtos');

        foreach($response as $item){
            logger()->info($item['id'], $item);
            $this->info($item['id']);
        }

    }
}
