<?php

namespace Bluesky\Controllers;

use Bluesky\Core\Controller;
use Bluesky\Core\Request;

class UserPostController extends Controller
{
    public function show(Request $request, int $userId, string $postSlug)
    {
        return response()->json(['msg' => 'User Single Post Page']);
    }
}