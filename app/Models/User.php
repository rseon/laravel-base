<?php

namespace App\Models;

use App\Scopes\LatestScope;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Eloquent\Active;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use Active;

    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getRoles()
    {
        return [
            static::ROLE_ADMIN => __('Administrator'),
            static::ROLE_USER => __('User'),
        ];
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new LatestScope);
    }

    public function hasRole(string $role)
    {
        return $this->role === $role;
    }

    public function isAdmin()
    {
        return $this->hasRole(static::ROLE_ADMIN);
    }

    public function isUser()
    {
        return $this->hasRole(static::ROLE_USER);
    }

    /**
     * Return the user's posts
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id');
    }

    /**
     * Check if the user can be an author
     */
    public function canBeAuthor(): bool
    {
        return true;//$this->isAdmin();
    }
}
