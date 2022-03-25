<?php

namespace Bluesky\Models;

use Bluesky\Core\Facades\Model;

class User extends Model
{
    protected array $fillable = [
        'name', 'email', 'phone', 'username'
    ];
    protected string $table = 'users';
    protected string $primaryKey = 'id';
}