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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

// Route::get('/home', 'HomeController@index')->name('home');


// Route::group(['middleware' => 'auth'], function () {

    Route::redirect('/', '/produse');

    Route::any('/produse/vanzari', 'ProdusController@vanzari');
    Route::any('produse/vanzari/descarca-produs', 'ProdusController@vanzariDescarcaProdus');
    Route::any('produse/vanzari/goleste-cos', 'ProdusController@vanzariGolesteCos');

    Route::resource('produse', 'ProdusController');
    

    Route::get('/makethemigration', function() {
        Artisan::call('php artisan migrate:refresh --seed');
    return "Cleared!";
    });

// });
