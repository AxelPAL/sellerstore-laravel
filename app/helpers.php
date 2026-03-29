<?php

declare(strict_types=1);

use Illuminate\Support\Arr;

if (! function_exists('setting')) {
    /**
     * Site settings (dot keys), compatible with legacy Voyager-style views.
     *
     * @return ($key is null ? array<string, mixed> : mixed)
     */
    function setting(?string $key = null, mixed $default = null): mixed
    {
        /** @var array<string, mixed> $settings */
        $settings = config('settings', []);

        if ($key === null || $key === '') {
            return $settings;
        }

        return Arr::get($settings, $key, $default);
    }
}
