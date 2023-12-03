<?php

namespace App\Services\ProviderAdapters;

use App\DTO\Articles;

interface ProviderAdapterInterface
{
    public function getNews(): Articles;
}
