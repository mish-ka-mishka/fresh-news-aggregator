<?php

namespace App\Services\ProviderAdapters;

use App\DTO\Articles;
use App\Http\Integrations\TheGuardian\Requests\ContentRequest;
use App\Http\Integrations\TheGuardian\TheGuardianConnector;

class TheGuardianAdapter extends AbstractProviderAdapter implements ProviderAdapterInterface
{
    protected TheGuardianConnector $connector;

    public function __construct()
    {
        $this->connector = new TheGuardianConnector(config('news_providers.theguardian.api_key'));
    }

    public function getNews(): Articles
    {
        $request = new ContentRequest();

        $response = $this->connector->send($request);

        return self::setProvider($response->dtoOrFail());
    }
}
