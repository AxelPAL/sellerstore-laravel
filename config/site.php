<?php

return [
    'yandex_metrics'      => env('SITE_YANDEX_METRICS', ''),
    'google_analytics'    => env('SITE_GOOGLE_ANALYTICS', ''),
    'blocked_product_ids' => array_values(array_filter(array_map(
        'trim',
        explode(',', (string) env('BLOCKED_PRODUCT_IDS', ''))
    ), static fn (string $id): bool => $id !== '')),
    'referral_code'       => env('REFERRAL_CODE', ''),
    'app_url_domain'      => env('APP_URL_DOMAIN', ''),
];
