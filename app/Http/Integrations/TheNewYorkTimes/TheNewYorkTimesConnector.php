<?php

namespace App\Http\Integrations\TheNewYorkTimes;

use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class TheNewYorkTimesConnector extends Connector
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
}
