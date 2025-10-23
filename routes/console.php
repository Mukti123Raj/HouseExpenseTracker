<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Register PWA command
Artisan::command('pwa:generate', function () {
    $this->info('Generating PWA files...');

    // Generate manifest.json
    $config = config('pwa');
    
    $manifest = [
        'name' => $config['name'],
        'short_name' => $config['short_name'],
        'description' => $config['description'],
        'start_url' => $config['start_url'],
        'display' => $config['display'],
        'background_color' => $config['background_color'],
        'theme_color' => $config['theme_color'],
        'orientation' => $config['orientation'],
        'scope' => $config['scope'],
        'lang' => $config['lang'],
        'icons' => $config['icons']
    ];

    $manifestPath = public_path('manifest.json');
    File::put($manifestPath, json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    $this->info('✓ manifest.json generated');
    
    // Generate serviceworker.js
    $cacheName = $config['cache_name'];
    $urlsToCache = $config['cache_urls'];

    $serviceWorkerContent = "const CACHE_NAME = '{$cacheName}';
const urlsToCache = " . json_encode($urlsToCache, JSON_PRETTY_PRINT) . ";

// Install event - cache resources
self.addEventListener('install', function(event) {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(function(cache) {
                console.log('Opened cache');
                return cache.addAll(urlsToCache);
            })
    );
});

// Fetch event - serve from cache when offline
self.addEventListener('fetch', function(event) {
    event.respondWith(
        caches.match(event.request)
            .then(function(response) {
                // Return cached version or fetch from network
                if (response) {
                    return response;
                }
                return fetch(event.request);
            }
        )
    );
});

// Activate event - clean up old caches
self.addEventListener('activate', function(event) {
    event.waitUntil(
        caches.keys().then(function(cacheNames) {
            return Promise.all(
                cacheNames.map(function(cacheName) {
                    if (cacheName !== CACHE_NAME) {
                        console.log('Deleting old cache:', cacheName);
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});";

    $serviceWorkerPath = public_path('serviceworker.js');
    File::put($serviceWorkerPath, $serviceWorkerContent);
    $this->info('✓ serviceworker.js generated');

    $this->info('PWA files generated successfully!');
})->purpose('Generate PWA manifest.json and serviceworker.js files');
