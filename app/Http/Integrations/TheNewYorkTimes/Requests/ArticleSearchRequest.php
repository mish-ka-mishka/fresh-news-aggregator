<?php

namespace App\Http\Integrations\TheNewYorkTimes\Requests;

use App\DTO\Article;
use App\DTO\Articles;
use Carbon\Carbon;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class ArticleSearchRequest extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/search/v2/articlesearch.json';
    }

    public function createDtoFromResponse(Response $response): Articles
    {
        return new Articles($response->collect('response.docs')->map(function ($data) {
            return new Article(
                title: $data['headline']['main'],
                description: $data['abstract'],
                content: $data['lead_paragraph'],
                url: $data['web_url'],
                publishedAt: new Carbon($data['pub_date']),
                author: $data['byline']['original'],
                source: $data['source'],
            );
        }));
    }
}
