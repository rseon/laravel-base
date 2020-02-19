<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes([
    'register' => false,
]);

// Switch lang
Route::get('lang/{locale}', function(Request $request, string $locale) {
	session()->put('locale', $locale);
    app()->setLocale($locale);

    return back()->withInput();
})->name('switch_locale');

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');
Route::get('/posts', 'PostController@index')->name('posts');
Route::get('/post/{slug}', 'PostController@show')->name('post');
Route::get('/author/{user}', 'AuthorController@show')->name('author');
Route::get('/category/{category}', 'CategoryController@show')->name('category');
