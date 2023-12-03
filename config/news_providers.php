<?php

use App\Services\ProviderAdapters\NewsApiAdapter;
use App\Services\ProviderAdapters\TheGuardianAdapter;
use App\Services\ProviderAdapters\TheNewYorkTimesAdapter;

return [

    /*
    |--------------------------------------------------------------------------
    | News providers
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials and configuration for news providers.
    |
    */

    'adapters' => [
        NewsApiAdapter::class,
        TheGuardianAdapter::class,
        TheNewYorkTimesAdapter::class,
    ],

    'news_api' => [
        'api_key' => env('NEWS_API_KEY'),
        'sources' => [
            'bild',
            'der-tagesspiegel',
            'die-zeit',
            'focus',
            'gruenderszene',
            'handelsblatt',
            'spiegel-online',
            't3n',
            'wired-de',
            'wirtschafts-woche',
        ],
        'max_results' => 100, // Nullable. News API has a limit of 100 items total for dev accounts
    ],
    'theguardian' => [
        'api_key' => env('THEGUARDIAN_API_KEY'),
    ],
    'nytimes' => [
        'api_key' => env('NYTIMES_API_KEY'),
    ],
];
