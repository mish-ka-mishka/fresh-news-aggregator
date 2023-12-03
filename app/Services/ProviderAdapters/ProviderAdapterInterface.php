<?php

namespace App\Services\ProviderAdapters;

use Illuminate\Support\LazyCollection;

interface ProviderAdapterInterface
{
    public function getArticles(): LazyCollection;
}
