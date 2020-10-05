<?php
declare(strict_types=1);

namespace App\Models;

class SaleDto
{
    public int $product;
    public ?string $ip;
    public ?string $userAgent;
    public bool $isBot;
}
