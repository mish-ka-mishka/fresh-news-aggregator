<?php

namespace App\Http\Integrations\NewsApi;

use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\HasPagination;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class NewsApiConnector extends Connector implements HasPagination
{
    use AcceptsJson, AlwaysThrowOnErrors;

    public function __construct(
        protected string $apiKey
    ) {
        $this->withTokenAuth($apiKey, 'Bearer');
    }

    /**
     * The Base URL of the API
     */
    public function resolveBaseUrl(): string
    {
        return 'https://newsapi.org/v2';
    }

    /**
     * Default headers for every request
     */
    protected function defaultHeaders(): array
    {
        return [];
    }

    /**
     * Default HTTP client options
     */
    protected function defaultConfig(): array
    {
        return [];
    }

    public function paginate(Request $request): NewsApiPaginator
    {
        return new NewsApiPaginator(connector: $this, request: $request);
    }
}
