<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $ip
 * @property int $product
 * @property string $user_agent
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_bot
 */
final class Sale extends Model
{
    protected $fillable = ['ip', 'product', 'user_agent', 'created_at', 'updated_at', 'is_bot'];

    public function create(SaleDto $dto): bool
    {
        $sale = new self();
        $sale->product = $dto->product;
        $sale->ip = $dto->ip;
        $sale->user_agent = $dto->userAgent;
        $sale->is_bot = $dto->isBot;
        return $sale->save();
    }

}
