<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property string $url
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 */
class Page extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['title', 'url', 'content', 'created_at', 'updated_at'];

}
