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
class Sale extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['ip', 'product', 'user_agent', 'created_at', 'updated_at', 'is_bot'];

}
