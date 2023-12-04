<?php

namespace App\Http\Integrations\TheGuardian;

use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\PagedPaginator;
use function floor;

class TheGuardianPaginator extends PagedPaginator
{
    protected ?int $perPageLimit = 50;

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
            $request->query()->add('page-size', $this->perPageLimit);
        }

        return $request;
    }

    /**
     * Get the total number of pages
     */
    protected function getTotalPages(Response $response): int
    {
        return floor($response->json('total') / $this->perPageLimit);
    }
}
