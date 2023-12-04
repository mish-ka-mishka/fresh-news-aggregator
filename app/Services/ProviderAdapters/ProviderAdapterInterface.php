<?php

namespace App\Services\ProviderAdapters;

use DateTimeInterface;
use Illuminate\Support\LazyCollection;

interface ProviderAdapterInterface
{
    public function getArticles(?DateTimeInterface $date): LazyCollection;
}
