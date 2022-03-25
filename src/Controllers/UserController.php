<?php

namespace Bluesky\Controllers;

use Bluesky\Core\Controller;
use Bluesky\Core\Request;
use Bluesky\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = User::select('name', 'email', 'phone')
            ->where('name', 'Nihar Ranjan Das')
            ->where('name', 'like', '%Nihar')
            ->where([
                'email' => 'niharranjandasmu@gmail.com',
                'password' => '12345678'
            ])
            ->where([
                ['name', 'like', '%nihar%'],
                ['email', '=', 'niharranjandasmu@gmail.com'],
                ['phone', '=', '01761152186']
            ])
            ->where(function ($query) {
                $query->where('name', 'nihar')
                    ->orWhere('phone', 'like', '%0176');
            })
            ->get();
        dd($user);
    }

    public function show()
    {
        return response()->json(['msg' => 'Single User Page']);
    }


    public function edit()
    {
        return response()->json(['msg' => 'User Edit Page']);
    }
}