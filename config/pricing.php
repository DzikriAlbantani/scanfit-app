<?php

return [
    'plans' => [
        'basic' => [
            'name' => 'Basic',
            'monthly_price' => 0,
            'features' => [
                'scans_per_month' => 10,
                'closet_items' => 15,
                'albums' => 3,
            ],
        ],
        'plus' => [
            'name' => 'Plus',
            'monthly_price' => env('PRICE_PLUS_MONTHLY', 49000),
            'yearly_discount_months' => env('PRICE_PLUS_YEARLY_DISCOUNT_MONTHS', 2),
            'features' => [
                'scans_per_month' => 50,
                'closet_items' => 100,
                'albums' => 20,
                'priority_support' => true,
            ],
        ],
        'pro' => [
            'name' => 'Pro',
            'monthly_price' => env('PRICE_PRO_MONTHLY', 99000),
            'yearly_discount_months' => env('PRICE_PRO_YEARLY_DISCOUNT_MONTHS', 2),
            'features' => [
                'scans_per_month' => 'unlimited',
                'closet_items' => 'unlimited',
                'albums' => 'unlimited',
                'priority_support' => true,
                'advanced_analytics' => true,
            ],
        ],
    ],
    'brand_plans' => [
        'pro' => [
            'name' => 'Brand Pro',
            'monthly_price' => env('PRICE_BRAND_PRO_MONTHLY', 299000),
            'yearly_discount_months' => env('PRICE_BRAND_PRO_YEARLY_DISCOUNT_MONTHS', 2),
            'features' => [
                'analytics' => 'full',
                'banner_slots' => 'priority',
                'api_access' => true,
            ],
        ],
    ],
    'banner_daily_fee' => env('BANNER_DAILY_FEE', 15000),
];
