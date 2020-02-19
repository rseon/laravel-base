<?php

namespace App\Models;

use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Return the category's posts
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'posts_categories');
    }
}
