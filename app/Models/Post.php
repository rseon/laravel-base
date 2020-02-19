<?php

namespace App\Models;

use App\Scopes\LatestScope;
use App\Traits\Eloquent\Active;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{
    use SoftDeletes;
    use Active;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author_id', 'title', 'slug', 'content'
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['author', 'categories'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new LatestScope);
    }

    /**
     * Return the post's author
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Return the post's categories
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'posts_categories');
    }
}
