<?php

namespace App\Services\ProviderAdapters;

use App\Http\Integrations\TheNewYorkTimes\Requests\ArticleSearchRequest;
use App\Http\Integrations\TheNewYorkTimes\TheNewYorkTimesConnector;
use Illuminate\Support\LazyCollection;

class TheNewYorkTimesAdapter extends AbstractProviderAdapter implements ProviderAdapterInterface
{
    protected TheNewYorkTimesConnector $connector;

    public function __construct()
    {
        $this->connector = new TheNewYorkTimesConnector(config('news_providers.nytimes.api_key'));
    }

    public function getArticles(): LazyCollection
    {
        $request = new ArticleSearchRequest();
        $response = $this->connector->paginate($request);

        return self::setProvider($response->collect());
    }
}
