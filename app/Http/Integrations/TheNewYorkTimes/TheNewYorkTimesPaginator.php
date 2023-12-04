<?php

namespace App\Http\Integrations\TheNewYorkTimes;

use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\PagedPaginator;
use function floor;

class TheNewYorkTimesPaginator extends PagedPaginator
{
    protected ?int $perPageLimit = 10;

    protected function isLastPage(Response $response): bool
    {
        return $this->page >= $this->getTotalPages($response);
    }

    protected function getPageItems(Response $response, Request $request): array
    {
        return $response->dtoOrFail();
    }

    /**
     * Get the total number of pages
     */
    protected function getTotalPages(Response $response): int
    {
        return floor($response->json('meta.hits') / $this->perPageLimit);
    }
}
