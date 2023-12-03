<?php

namespace App\Http\Integrations\TheGuardian;

use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class TheGuardianConnector extends Connector
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
}
