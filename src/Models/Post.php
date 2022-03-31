<?php

namespace Bluesky\Models;

use Bluesky\Core\Orm\Model;

class Post extends Model
{
    protected array $fillable = [
        'title', 'slug', 'content', 'category_id', 'user_id', 'status'
    ];
    
    protected string $table = 'users';
    protected string $primaryKey = 'id';
}