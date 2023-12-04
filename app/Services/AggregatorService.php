<?php

namespace App\Services;

use App\Models\Article;
use App\Repositories\ArticleRepositoryInterface;
use App\Services\ProviderAdapters\ProviderAdapterInterface;
use Carbon\Carbon;
use function config;

class AggregatorService
{
    /** @var ProviderAdapterInterface[] $adapters */
    protected array $adapters;

    public function __construct(
        protected ArticleRepositoryInterface $articleRepository
    ) {
        $adaptersClasses = config('news_providers.adapters', []);

        foreach ($adaptersClasses as $adapter) {
            $this->adapters[] = self::instantiate($adapter);
        }
    }

    public function fetchArticles(): void
    {
        foreach ($this->adapters as $adapter) {
            $articles = $adapter->getArticles(new Carbon());

            $articles->each(function ($articleDto) {
                $article = $this->articleRepository->getByUrl($articleDto->getUrl());

                if ($article === null) {
                    $article = Article::fromDto($articleDto);
                } else {
                    $article->updateFromDto($articleDto);
                }

                $this->articleRepository->persist($article);
            });
        }

        $this->articleRepository->deleteOldArticles(new Carbon('-1 day'));
    }

    protected static function instantiate(string $adapter): ProviderAdapterInterface
    {
        return new $adapter;
    }
}
