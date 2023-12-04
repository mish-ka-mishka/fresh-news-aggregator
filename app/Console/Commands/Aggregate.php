<?php

namespace App\Console\Commands;

use App\DTO\Article;
use App\Services\AggregatorService;
use Illuminate\Console\Command;
use function var_dump;

class Aggregate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:aggregate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(AggregatorService $service)
    {
        $service->fetchArticles();
    }
}
