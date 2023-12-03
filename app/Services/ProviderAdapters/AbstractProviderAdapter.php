<?php

namespace App\Services\ProviderAdapters;

use App\DTO\Article;
use App\DTO\Articles;

abstract class AbstractProviderAdapter
{
    protected static function setProvider(Articles $articles): Articles
    {
        return $articles->each(fn(Article $article) => $article->setProvider(static::class));
    }
}
