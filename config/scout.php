<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Search Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default search connection that gets used while
    | using Laravel Scout. This connection is used when syncing all models
    | to the search service. You should adjust this based on your needs.
    |
    | Supported: "algolia", "meilisearch", "tntsearch", "null"
    |
    */

    'driver' => env('SCOUT_DRIVER', 'meilisearch'),

    /*
    |--------------------------------------------------------------------------
    | MeiliSearch Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your MeiliSearch settings.
    |
    */

    'meilisearch' => [
        'host' => env('MEILISEARCH_HOST', 'http://localhost:7700'),
        'key' => env('MEILISEARCH_KEY', null),
    ],

    // ... autres configurations ...
];