<?php

namespace App\Repositories;

use App\Models\Article;
use DateTimeInterface;

interface ArticleRepositoryInterface
{
    public function getByUrl(string $url): ?Article;

    public function persist(Article $article): void;

    public function deleteOldArticles(DateTimeInterface $threshold): void;
}
