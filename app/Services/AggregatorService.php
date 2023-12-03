<?php

namespace App\Services;

use App\DTO\Articles;
use App\Services\ProviderAdapters\ProviderAdapterInterface;
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

    public function getNews(): Articles
    {
        $articles = new Articles();

        foreach ($this->adapters as $adapter) {
            $articles = $articles->merge($adapter->getNews());
        }

        return $articles;
    }

    protected static function instantiate(string $adapter): ProviderAdapterInterface
    {
        return new $adapter;
    }
}
