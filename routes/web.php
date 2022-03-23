<?php

use Bluesky\Core\Facades\Router;

Router::get('users', 'UserController@index')->name('users.index');
Router::get('users/:id', 'UserController@show')->name('users.show');
Router::get('users/:id/edit', 'UserController@edit')->name('users.edit');
Router::get('users/:id/posts/:slug', 'UserPostController@show')->name('users.posts.show');
