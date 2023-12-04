<?php

namespace App\Services\ProviderAdapters;

use App\DTO\Article;
use App\Http\Integrations\NewsApi\NewsApiConnector;
use App\Http\Integrations\NewsApi\Requests\EverythingRequest;
use DateTimeInterface;
use Illuminate\Support\LazyCollection;

class NewsApiAdapter extends AbstractProviderAdapter implements ProviderAdapterInterface
{
    protected NewsApiConnector $connector;

    public function __construct()
    {
        $this->connector = new NewsApiConnector(config('news_providers.news_api.api_key'));
    }

    public function getArticles(?DateTimeInterface $date): LazyCollection
    {
        $request = new EverythingRequest($date);
        $response = $this->connector->paginate($request);

        return self::setProvider($response->collect()->filter(
            fn(Article $article) => $article->getTitle() !== '[Removed]' && $article->getContent() !== '[Removed]'
        ));
    }
}
