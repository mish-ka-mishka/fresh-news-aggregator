<?php

namespace App\Services\ProviderAdapters;

use App\DTO\Article;
use App\DTO\Articles;
use App\Http\Integrations\NewsApi\NewsApiConnector;
use App\Http\Integrations\NewsApi\Requests\EverythingRequest;

class NewsApiAdapter extends AbstractProviderAdapter implements ProviderAdapterInterface
{
    protected NewsApiConnector $connector;

    public function __construct()
    {
        $this->connector = new NewsApiConnector(config('news_providers.news_api.api_key'));
    }

    public function getNews(): Articles
    {
        $request = new EverythingRequest();

        $response = $this->connector->send($request);

        /** @var Articles $articles */
        $articles = $response->dtoOrFail();

        return self::setProvider($articles->filter(
            fn(Article $article) => $article->getTitle() !== '[Removed]' && $article->getContent() !== '[Removed]'
        ));
    }
}
