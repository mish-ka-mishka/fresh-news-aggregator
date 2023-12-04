<?php

namespace App\Http\Integrations\NewsApi;

use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\PagedPaginator;
use function floor;

class NewsApiPaginator extends PagedPaginator
{
    protected ?int $perPageLimit = 50;

    public function __construct(Connector $connector, Request $request)
    {
        parent::__construct($connector, $request);

        $maxResults = config('news_providers.news_api.max_results');

        if ($maxResults !== null) {
            $this->maxPages = floor($maxResults / $this->perPageLimit);
        }
    }

    protected function isLastPage(Response $response): bool
    {
        return $this->page >= $this->getTotalPages($response);
    }

    protected function getPageItems(Response $response, Request $request): array
    {
        return $response->dtoOrFail();
    }

    protected function applyPagination(Request $request): Request
    {
        $request->query()->add('page', $this->page);

        if (isset($this->perPageLimit)) {
            $request->query()->add('pageSize', $this->perPageLimit);
        }

        return $request;
    }

    /**
     * Get the total number of pages
     */
    protected function getTotalPages(Response $response): int
    {
        return floor($response->json('totalResults') / $this->perPageLimit);
    }
}
