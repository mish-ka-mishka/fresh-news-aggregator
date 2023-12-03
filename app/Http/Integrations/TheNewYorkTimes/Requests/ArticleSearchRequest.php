<?php

namespace App\Http\Integrations\TheNewYorkTimes\Requests;

use App\DTO\Article;
use Carbon\Carbon;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;

class ArticleSearchRequest extends Request implements Paginatable
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

    /**
     * @return Article[]
     */
    public function createDtoFromResponse(Response $response): array
    {
        return array_map(function ($data) {
            return new Article(
                title: $data['headline']['main'],
                description: $data['abstract'],
                content: $data['lead_paragraph'],
                url: $data['web_url'],
                publishedAt: new Carbon($data['pub_date']),
                author: $data['byline']['original'],
                source: $data['source'],
            );
        }, $response->json('response.docs'));
    }
}
