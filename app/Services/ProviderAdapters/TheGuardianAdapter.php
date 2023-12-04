<?php

namespace App\Services\ProviderAdapters;

use App\Http\Integrations\TheGuardian\Requests\ContentRequest;
use App\Http\Integrations\TheGuardian\TheGuardianConnector;
use DateTimeInterface;
use Illuminate\Support\LazyCollection;

class TheGuardianAdapter extends AbstractProviderAdapter implements ProviderAdapterInterface
{
    protected TheGuardianConnector $connector;

    public function __construct()
    {
        $this->connector = new TheGuardianConnector(config('news_providers.theguardian.api_key'));
    }

    public function getArticles(?DateTimeInterface $date): LazyCollection
    {
        $request = new ContentRequest($date);
        $response = $this->connector->paginate($request);

        return self::setProvider($response->collect());
    }
}
