<?php

namespace App\Http\Integrations\TheGuardian\Requests;

use App\DTO\Article;
use Carbon\Carbon;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;

class ContentRequest extends Request implements Paginatable
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
        return '/search';
    }

    public function defaultQuery(): array
    {
        return [
            'format' => 'json',
            'show-fields' => 'headline,body,byline,thumbnail',
        ];
    }

    /**
     * @return Article[]
     */
    public function createDtoFromResponse(Response $response): array
    {
        return array_map(function ($data) {
            return new Article(
                title: $data['webTitle'],
                description: $data['fields']['headline'],
                content: $data['fields']['body'],
                url: $data['webUrl'],
                publishedAt: new Carbon($data['webPublicationDate']),
                author: $data['fields']['byline'] ?? null,
                coverUrl: $data['fields']['thumbnail'] ?? null,
            );
        }, $response->json('response.results'));
    }
}
