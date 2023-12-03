<?php

namespace App\Services\ProviderAdapters;

use App\DTO\Article;
use Illuminate\Support\LazyCollection;

abstract class AbstractProviderAdapter
{
    protected static function setProvider(LazyCollection $articles): LazyCollection
    {
        return $articles->map(function(Article $article) {
            $article->setProvider(static::class);

            return $article;
        });
    }
}
