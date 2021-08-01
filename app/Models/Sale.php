<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Sale
 *
 * @property int $id
 * @property string $ip
 * @property int $product
 * @property string $user_agent
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_bot
 * @method static Builder|Sale newModelQuery()
 * @method static Builder|Sale newQuery()
 * @method static Builder|Sale query()
 * @method static Builder|Sale whereCreatedAt($value)
 * @method static Builder|Sale whereId($value)
 * @method static Builder|Sale whereIp($value)
 * @method static Builder|Sale whereIsBot($value)
 * @method static Builder|Sale whereProduct($value)
 * @method static Builder|Sale whereUpdatedAt($value)
 * @method static Builder|Sale whereUserAgent($value)
 * @mixin Eloquent
 */
final class Sale extends Model
{
    protected const IS_BOT = 1;
    protected const IS_NOT_BOT = 0;

    protected $fillable = ['ip', 'product', 'user_agent', 'created_at', 'updated_at', 'is_bot'];

    public function create(SaleDto $dto): bool
    {
        $sale = new self();
        $sale->product = $dto->product;
        $sale->ip = (string)$dto->ip;
        $sale->user_agent = (string)$dto->userAgent;
        $sale->is_bot = $dto->isBot ? self::IS_BOT : self::IS_NOT_BOT;
        return $sale->save();
    }
}
