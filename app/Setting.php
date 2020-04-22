<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property string $code
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 */
class Setting extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['title', 'code', 'content', 'created_at', 'updated_at'];
}
