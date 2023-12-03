<?php

namespace App\Services\ProviderAdapters;

use App\Http\Integrations\TheGuardian\Requests\ContentRequest;
use App\Http\Integrations\TheGuardian\TheGuardianConnector;
use Illuminate\Support\LazyCollection;

class TheGuardianAdapter extends AbstractProviderAdapter implements ProviderAdapterInterface
{
    protected TheGuardianConnector $connector;

    public function __construct()
    {
        $this->connector = new TheGuardianConnector(config('news_providers.theguardian.api_key'));
    }

    public function getArticles(): LazyCollection
    {
        $request = new ContentRequest();
        $response = $this->connector->paginate($request);

        return self::setProvider($response->collect());
    }
}
