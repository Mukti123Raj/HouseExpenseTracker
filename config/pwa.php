<?php

return [
    /*
    |--------------------------------------------------------------------------
    | PWA Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for Progressive Web App features
    | of the FinTrack application.
    |
    */

    'name' => env('PWA_NAME', 'FinTrack'),
    'short_name' => env('PWA_SHORT_NAME', 'FinTrack'),
    'description' => env('PWA_DESCRIPTION', 'House Expense Tracker - Manage your household finances'),
    'start_url' => env('PWA_START_URL', '/'),
    'display' => env('PWA_DISPLAY', 'standalone'),
    'background_color' => env('PWA_BACKGROUND_COLOR', '#ffffff'),
    'theme_color' => env('PWA_THEME_COLOR', '#000000'),
    'orientation' => env('PWA_ORIENTATION', 'portrait-primary'),
    'scope' => env('PWA_SCOPE', '/'),
    'lang' => env('PWA_LANG', 'en'),

    /*
    |--------------------------------------------------------------------------
    | PWA Icons
    |--------------------------------------------------------------------------
    |
    | Configuration for PWA icons in various sizes
    |
    */
    'icons' => [
        [
            'src' => '/images/icons/icon-72x72.png',
            'sizes' => '72x72',
            'type' => 'image/png',
            'purpose' => 'maskable any'
        ],
        [
            'src' => '/images/icons/icon-96x96.png',
            'sizes' => '96x96',
            'type' => 'image/png',
            'purpose' => 'maskable any'
        ],
        [
            'src' => '/images/icons/icon-128x128.png',
            'sizes' => '128x128',
            'type' => 'image/png',
            'purpose' => 'maskable any'
        ],
        [
            'src' => '/images/icons/icon-144x144.png',
            'sizes' => '144x144',
            'type' => 'image/png',
            'purpose' => 'maskable any'
        ],
        [
            'src' => '/images/icons/icon-152x152.png',
            'sizes' => '152x152',
            'type' => 'image/png',
            'purpose' => 'maskable any'
        ],
        [
            'src' => '/images/icons/icon-192x192.png',
            'sizes' => '192x192',
            'type' => 'image/png',
            'purpose' => 'maskable any'
        ],
        [
            'src' => '/images/icons/icon-384x384.png',
            'sizes' => '384x384',
            'type' => 'image/png',
            'purpose' => 'maskable any'
        ],
        [
            'src' => '/images/icons/icon-512x512.png',
            'sizes' => '512x512',
            'type' => 'image/png',
            'purpose' => 'maskable any'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Service Worker Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the service worker caching strategy
    |
    */
    'cache_name' => env('PWA_CACHE_NAME', 'fintrack-v1'),
    'cache_urls' => [
        '/',
        '/css/app.css',
        '/js/app.js',
        '/images/icons/icon-192x192.png',
        '/images/icons/icon-512x512.png',
        '/favicon.ico',
        '/favicon.svg',
        '/apple-touch-icon.png'
    ]
];

