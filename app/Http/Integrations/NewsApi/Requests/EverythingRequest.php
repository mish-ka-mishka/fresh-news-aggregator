<?php

namespace App\Http\Integrations\NewsApi\Requests;

use App\DTO\Article;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use DateTimeInterface;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use function implode;

class EverythingRequest extends Request implements Paginatable
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
        return '/everything';
    }

    public function defaultQuery(): array
    {
        $query = [
            'sources' => implode(',', config('news_providers.news_api.sources', [])),
        ];

        if ($this->date) {
            $query['from'] = (new CarbonImmutable($this->date))->startOfDay()->format(DateTimeInterface::ATOM);
            $query['to'] = (new CarbonImmutable($this->date))->endOfDay()->format(DateTimeInterface::ATOM);
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
                title: $data['title'],
                description: $data['description'],
                content: $data['content'],
                url: $data['url'],
                publishedAt: new Carbon($data['publishedAt']),
                author: $data['author'],
                coverUrl: $data['urlToImage'],
                source: $data['source']['name'],
            );
        }, $response->json('articles'));
    }
}
