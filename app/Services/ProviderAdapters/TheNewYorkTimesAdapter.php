<?php

namespace App\Services\ProviderAdapters;

use App\Http\Integrations\TheNewYorkTimes\Requests\ArticleSearchRequest;
use App\Http\Integrations\TheNewYorkTimes\TheNewYorkTimesConnector;
use DateTimeInterface;
use Illuminate\Support\LazyCollection;

class TheNewYorkTimesAdapter extends AbstractProviderAdapter implements ProviderAdapterInterface
{
    protected TheNewYorkTimesConnector $connector;

    public function __construct()
    {
        $this->connector = new TheNewYorkTimesConnector(config('news_providers.nytimes.api_key'));
    }

    public function getArticles(?DateTimeInterface $date): LazyCollection
    {
        $request = new ArticleSearchRequest($date);
        $response = $this->connector->paginate($request);

        return self::setProvider($response->collect());
    }
}
