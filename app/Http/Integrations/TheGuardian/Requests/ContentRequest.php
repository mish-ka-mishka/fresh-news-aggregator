<?php

namespace App\Http\Integrations\TheGuardian\Requests;

use App\DTO\Article;
use Carbon\Carbon;
use DateTimeInterface;
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

    public function __construct(
        protected ?DateTimeInterface $date = null
    ) {
    }

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/search';
    }

    public function defaultQuery(): array
    {
        $query = [
            'format' => 'json',
            'show-fields' => 'headline,body,byline,thumbnail',
        ];

        if ($this->date) {
            $query['from-date'] = $this->date->format('Y-m-d');
            $query['to-date'] = $this->date->format('Y-m-d');
        }

        return $query;
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
