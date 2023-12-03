<?php

namespace App\Http\Integrations\TheNewYorkTimes;

use Illuminate\Support\Facades\Cache;
use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\HasPagination;
use Saloon\RateLimitPlugin\Contracts\RateLimitStore;
use Saloon\RateLimitPlugin\Limit;
use Saloon\RateLimitPlugin\Stores\LaravelCacheStore;
use Saloon\RateLimitPlugin\Traits\HasRateLimits;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class TheNewYorkTimesConnector extends Connector implements HasPagination
{
    use AcceptsJson, AlwaysThrowOnErrors, HasRateLimits;

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
        return 'https://api.nytimes.com/svc/';
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

    public function paginate(Request $request): TheNewYorkTimesPaginator
    {
        return new TheNewYorkTimesPaginator(connector: $this, request: $request);
    }

    protected function resolveLimits(): array
    {
        return [
            Limit::allow(5)->everyMinute()->sleep(),
            Limit::allow(500)->everyDay(),
        ];
    }

    protected function resolveRateLimitStore(): RateLimitStore
    {
        return new LaravelCacheStore(Cache::store());
    }
}
