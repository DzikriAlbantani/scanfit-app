<?php

return [
    // Total free scans per user (lifetime)
    'free_limit' => env('SCAN_FREE_LIMIT', 10),

    // Redirect route when quota exceeded (set to null to use flash message only)
    // Default to 'pricing.index' for a canonical upsell route
    'upgrade_route' => env('SCAN_UPGRADE_ROUTE', 'pricing.index'),
];
