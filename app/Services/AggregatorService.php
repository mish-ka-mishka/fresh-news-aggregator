<?php

namespace App\Services;

use App\Services\ProviderAdapters\ProviderAdapterInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;
use function config;

class AggregatorService
{
    /** @var ProviderAdapterInterface[] $adapters */
    protected array $adapters;

    public function __construct()
    {
        $adaptersClasses = config('news_providers.adapters', []);

        foreach ($adaptersClasses as $adapter) {
            $this->adapters[] = self::instantiate($adapter);
        }
    }

    public function fetchNews(): void
    {
        foreach ($this->adapters as $adapter) {
            $articles = $adapter->getArticles();

            $articles->each(function ($article) {
                echo $article->getTitle() . PHP_EOL;
            });
        }
    }

    protected static function instantiate(string $adapter): ProviderAdapterInterface
    {
        return new $adapter;
    }
}
