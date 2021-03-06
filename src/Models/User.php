<?php

namespace Bluesky\Models;

use Bluesky\Core\Orm\Model;

class User extends Model
{
    protected array $fillable = [
        'name', 'email', 'phone', 'username'
    ];
    protected string $table = 'users';
    protected string $primaryKey = 'id';


    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }
}