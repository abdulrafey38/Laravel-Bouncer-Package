<?php

use Illuminate\Support\Facades\Route;
use App\User;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Creating Roles quickly and assign them abilities
Route::any('/createRoles', function () {
    Bouncer::allow('admin')->to('create');
    Bouncer::allow('admin')->to('edit');
    Bouncer::allow('admin')->to('destroy');
    Bouncer::allow('editor')->to('edit');
    Bouncer::allow('creator')->to('create');

});

//Assign roles to user hard coded thid time but are these assign to user at registration process
Route::any('/assignRoles', function () {
   $admin = User::find(1);
   $editor = User::find(2);
   $creator = User::find(3);

   $admin->assign('admin');
   $editor->assign('editor');
   $creator->assign('creator');

});

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth:web']], function () {

    //user having abilities of creating post only user these routes
    Route::group(['middleware' => ['can:create']], function () {
        Route::any('/post/create','postController@create')->name('post.create');
        Route::post('/post','postController@store')->name('post.store');
        Route::get('/post','postController@index')->name('post.index');

    });
     //user having abilities of edit post only user these routes
    Route::group(['middleware' => ['can:edit']], function () {

        Route::any('/post/{post}','postController@update')->name('post.update');
        Route::get('/post/{post}/edit','postController@edit')->name('post.edit');
        Route::get('/post','postController@index')->name('post.index');
    });
     //user having abilities of delete post only user these routes
    Route::group(['middleware' => ['can:destroy']], function () {
        Route::any('/post/{post}','postController@destroy')->name('post.destroy');
        Route::get('/post','postController@index')->name('post.index');

    });

});

