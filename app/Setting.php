<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Setting
 *
 * @property int $id
 * @property string $title
 * @property string $code
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 * @property string $key
 * @property string $display_name
 * @property string|null $value
 * @property string|null $details
 * @property string $type
 * @property int $order
 * @property string|null $group
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereValue($value)
 * @mixin \Eloquent
 */
class Setting extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['title', 'code', 'content', 'created_at', 'updated_at'];
}
