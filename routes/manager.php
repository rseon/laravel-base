<?php

/*
|--------------------------------------------------------------------------
| Manager Routes
|--------------------------------------------------------------------------
*/

Route::get('', 'HomeController@index')->name('home');
Route::get('profile', 'UserController@profile')->name('user.profile');
Route::put('profile', 'UserController@updateProfile')->name('user.update_profile');

Route::apiResource('posts', 'PostController');
Route::resource('categories', 'CategoryController');

// Only for admin
Route::middleware(['role:admin'])->group(function () {
    Route::resource('users', 'UserController', [
        'except' => ['show']
    ]);
    Route::get('/users/{user}/restore', 'UserController@restore')->name('users.restore');
});

