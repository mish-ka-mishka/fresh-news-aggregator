<?php

namespace App\Services\ProviderAdapters;

use App\DTO\Articles;
use App\Http\Integrations\TheNewYorkTimes\Requests\ArticleSearchRequest;
use App\Http\Integrations\TheNewYorkTimes\TheNewYorkTimesConnector;

class TheNewYorkTimesAdapter extends AbstractProviderAdapter implements ProviderAdapterInterface
{
    protected TheNewYorkTimesConnector $connector;

    public function __construct()
    {
        $this->connector = new TheNewYorkTimesConnector(config('news_providers.nytimes.api_key'));
    }

    public function getNews(): Articles
    {
        $request = new ArticleSearchRequest();

        $response = $this->connector->send($request);

        return self::setProvider($response->dtoOrFail());
    }
}
