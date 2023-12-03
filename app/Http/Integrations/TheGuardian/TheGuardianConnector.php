<?php

namespace App\Http\Integrations\TheGuardian;

use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\HasPagination;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class TheGuardianConnector extends Connector implements HasPagination
{
    use AcceptsJson, AlwaysThrowOnErrors;

    public function __construct(
        protected string $apiKey
    ) {
        $this->withQueryAuth('api-key', $apiKey);
    }

    /**
     * The Base URL of the API
     */
    public function resolveBaseUrl(): string
    {
        return 'https://content.guardianapis.com/';
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

    public function paginate(Request $request): TheGuardianPaginator
    {
        return new TheGuardianPaginator(connector: $this, request: $request);
    }
}
