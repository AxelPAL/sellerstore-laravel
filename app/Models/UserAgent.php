<?php

namespace App\Models;

class UserAgent
{
    private const BOT_LIST = [
        'bot',
    ];

    public function checkIsBot(string $userAgent): bool
    {
        $result = false;
        foreach (self::BOT_LIST as $bot) {
            $result = $result || stripos($userAgent, $bot) !== false;
        }
        return $result;
    }
}
