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

    Route::get('/', 'HomeController@index')->name('home');
    Route::get('post/{slug}', 'PostController@details')->name('details.post');
    Auth::routes();
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::post('subscriber', 'SubscriberController@store')->name('subscriber.store');
    Route::get('/posts', 'PostController@index')->name('posts.index');
    Route::get('/category/{slug}', 'PostController@category')->name('category.posts');
    Route::get('/tag/{slug}', 'PostController@tag')->name('tag.posts');
    Route::get('/search', 'SearchController@search')->name('search');
    Route::get('/profile/{username}/', 'AuthorController@profile')->name('author.profile');


//Here is Admin Route Group.........................................................
Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['admin']], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    Route::get('settings', 'SettingsController@index')->name('settings');
    Route::put('profile-update', 'SettingsController@updateProfile')->name('profile.update');
    Route::put('password-update', 'SettingsController@updatePassword')->name('password.update');

    Route::resource('tag', 'TagController');
    Route::resource('category', 'CategoryController');
    Route::resource('post', 'PostController');

    Route::get('/comments', 'CommentController@index')->name('comment.index');
    Route::delete('/comments/{id}', 'CommentController@destroy')->name('comment.destroy');

    Route::get('/authors', 'AuthorController@index')->name('authors.index');
    Route::delete('/authors/{id}', 'AuthorController@destroy')->name('author.destroy');

    Route::get('/pending/post', 'PostController@pending')->name('post.pending');
    Route::put('/post/{id}/approve', 'PostController@approval')->name('post.approve');
    Route::get('/subscriber', 'SubscriberController@index')->name('subscriber.index');
    Route::get('/favorite', 'FavoriteController@index')->name('favorite.index');
    Route::delete('/subscriber/{subscriber}', 'SubscriberController@destroy')->name('subscriber.destroy');
});

//Here is Author Route Group............................
Route::group(['as' => 'author.', 'prefix' => 'author', 'namespace' => 'Author', 'middleware' => ['author']], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('post', 'PostController');

    Route::get('/comments', 'CommentsController@index')->name('comment.index');
    Route::delete('/comments/{id}', 'CommentsController@destroy')->name('comment.destroy');

    Route::get('/favorite', 'FavoriteController@index')->name('favorite.index');
    Route::get('settings', 'SettingsController@index')->name('settings');
    Route::put('profile-update', 'SettingsController@updateProfile')->name('profile.update');
    Route::put('password-update', 'SettingsController@updatePassword')->name('password.update');
});

//here is Favorite controller route..............
Route::group(['middleware' => 'auth'], function () {
    Route::post('favorite/{post}/add', 'FavoriteController@add')->name('post.favorite');
    Route::post('comment/{post}', 'CommentController@store')->name('comment.store');
});


View::composer('layouts.frontend.partial.footer', function($view){
    $category = App\Category::all();
    $view->with('categories', $category);
});

