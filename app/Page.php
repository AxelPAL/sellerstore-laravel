<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Page
 *
 * @property int $id
 * @property int $author_id
 * @property string $title
 * @property string $excerpt
 * @property string $body
 * @property string $image
 * @property string $slug
 * @property string $meta_description
 * @property string $meta_keywords
 * @property mixed $status
 * @property string $created_at
 * @property string $updated_at
 * @method static Builder|Page newModelQuery()
 * @method static Builder|Page newQuery()
 * @method static Builder|Page query()
 * @method static Builder|Page whereAuthorId($value)
 * @method static Builder|Page whereBody($value)
 * @method static Builder|Page whereCreatedAt($value)
 * @method static Builder|Page whereExcerpt($value)
 * @method static Builder|Page whereId($value)
 * @method static Builder|Page whereImage($value)
 * @method static Builder|Page whereMetaDescription($value)
 * @method static Builder|Page whereMetaKeywords($value)
 * @method static Builder|Page whereSlug($value)
 * @method static Builder|Page whereStatus($value)
 * @method static Builder|Page whereTitle($value)
 * @method static Builder|Page whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Page extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'author_id',
        'title',
        'excerpt',
        'body',
        'image',
        'slug',
        'meta_description',
        'meta_keywords',
        'status',
        'created_at',
        'updated_at',
    ];
}
