<?php

namespace Bluesky\Controllers;

use Bluesky\Core\Controller;
use Bluesky\Core\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        dd($request->all());
        return response()->json(['msg' => 'Users Page']);
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