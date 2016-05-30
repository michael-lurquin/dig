<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Routes non-authentifiées
Route::get('/dashboard', 'HomeController@index');
Route::get('/', 'HomeController@welcome');

Route::auth();

// Routes avec authentification
Route::group(['middleware' => 'auth'], function () {

    // Services
    Route::resource('service', 'ServiceController');
    Route::get('service/{service}/restore', 'ServiceController@restore')->where(['service' => '[a-z-\-0-9]+']);
    Route::get('service/{service}/export', 'ServiceController@export')->where(['service' => '[a-z-\-0-9]+']);

    // Révisions
    Route::get('service/{service}/revisions', ['uses' => 'RevisionController@index', 'as' => 'service.revisions'])->where(['service' => '[a-z-\-0-9]+']);
    Route::get('service/{service}/revisions/{id}/confirm', 'RevisionController@valid')->where(['service' => '[a-z-\-0-9]+', 'id' => '[0-9]+']);
    Route::get('service/{service}/revisions/{id}/restore', 'RevisionController@restore')->where(['service' => '[a-z-\-0-9]+', 'id' => '[0-9]+']);
    Route::delete('revision/{id}', 'RevisionController@destroy')->name('revision.destroy')->where(['id' => '[0-9]+']);

    // Permissions
    Route::get('permission', ['uses' => 'PermissionController@index', 'as' => 'permission.index']);
    Route::post('permission', ['uses' => 'PermissionController@update', 'as' => 'permission.update']);

    // Utilisateurs
    Route::resource('user', 'UserController');
    Route::get('user/{user}/restore', 'UserController@restore');

    // Profil
    Route::get('profile/{user}', ['uses' => 'UserController@edit', 'as' => 'profile']);

    // Catégories
    Route::resource('category', 'CategoryController');

    // Disponibilités
    Route::resource('availability', 'AvailabilityController');
});

// Route non-authentifiée qui écrase la même route qui se trouve dans les routes authentifiées
Route::get('service/{service}/show', ['uses' => 'ServiceController@show', 'as' => 'service.show'])->where(['service' => '[a-z-\-0-9]+']);
