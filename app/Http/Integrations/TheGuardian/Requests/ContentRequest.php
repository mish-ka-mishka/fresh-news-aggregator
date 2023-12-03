<?php

namespace App\Http\Integrations\TheGuardian\Requests;

use App\DTO\Article;
use App\DTO\Articles;
use Carbon\Carbon;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class ContentRequest extends Request
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

    public function createDtoFromResponse(Response $response): Articles
    {
        return new Articles($response->collect('response.results')->map(function ($data) {
            return new Article(
                title: $data['webTitle'],
                description: $data['fields']['headline'],
                content: $data['fields']['body'],
                url: $data['webUrl'],
                publishedAt: new Carbon($data['webPublicationDate']),
                author: $data['fields']['byline'],
                coverUrl: $data['fields']['thumbnail'],
            );
        }));
    }
}
