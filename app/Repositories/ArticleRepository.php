<?php

namespace App\Repositories;

use App\Models\Article;
use DateTimeInterface;
use Throwable;

class ArticleRepository implements ArticleRepositoryInterface
{
    public function getByUrl(string $url): ?Article
    {
        return Article::where('url', $url)->first();
    }

    /**
     * @throws Throwable
     */
    public function persist(Article $article): void
    {
        $article->saveOrFail();
    }

    public function deleteOldArticles(DateTimeInterface $threshold): void
    {
        Article::where('published_at', '<', $threshold)->delete();
    }
}
