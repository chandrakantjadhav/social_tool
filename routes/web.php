<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('back.dashboard');
})->middleware(['auth','verified'])->name('dashboard');


// Route to upload user avatar.
Route::post('/profile/upload', 'ProfileController@updateAvatar')->name('back.profile.uploadAvatar');
// Route to show user avatar
 // Route to show user avatar
 Route::get('/images/{id}/avatar/{image}', [
    'uses' => 'App\Http\Controllers\ProfileController@userProfileAvatar',
]);
// Route::put('/profile/{username}', 'ProfileController@update')->name('back.profile.update');

Route::get('/profile/{id}', 'ProfileController@show')->name('back.profile');
Route::post('/profile/{id}','ProfileController@update')->name('back.profile.update');


Route::post('/profile/updateUserPassword/{id}', 'ProfileController@updateUserPassword')->name('back.profile.updateUserPassword');
// Route::get('/profile/update', 'ProfileController@update')->name('back.profile.update');

require __DIR__.'/auth.php';

// frontend pages 
Route::get('/', 'PageController@index')->name('home');

 
Route::get('/posts', 'PageController@posts')->name('posts');
Route::get('/posts/{post}', 'PageController@showPost')->name('posts.view');
Route::get('/category/{category}', 'PageController@showCategory')->name('categories.view');

// admin pages 
Route::group(['prefix' => '/admin', 'middleware' => 'auth'], function () {
    Route::resource('posts','PostController');   
    Route::resource('categories','CategoryController')->except('show');
});