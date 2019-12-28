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


Route::group(['middleware' => 'auth'], function () {

    Route::redirect('/', '/produse');

    // Pagina de vanzari
    Route::any('/produse/vanzari', 'ProdusController@vanzari');
    Route::any('produse/vanzari/descarca-produs', 'ProdusController@vanzariDescarcaProdus');
    Route::any('produse/vanzari/goleste-cos', 'ProdusController@vanzariGolesteCos');
    // Extras date cu Axios
    Route::get('/produse/axios_date_produs', 'ProdusController@axios_date_produs');
    // Generare barcoduri pentru printare
    Route::any('produse/{produse}/export/{view_type}', 'ProdusController@pdfExportBarcode');
    // Rutele default ale controllerului
    Route::resource('produse', 'ProdusController');

    // Rute pentru rapoarte
    Route::any('produse-vandute/rapoarte/raport-zilnic/{view_type?}', 'ProdusVandutController@rapoarteRaportZilnic');
    Route::get('produse-vandute/rapoarte/raport-zilnic/{data_traseu}/export/{view_type}', 'ProdusVandutController@pdfExportRaportZilnic');
    // Rutele default ale controllerului
    Route::resource('produse-vandute', 'ProdusVandutController');
    

    Route::get('/makethemigration', function() {
        Artisan::call('php artisan migrate:refresh --seed');
    return "Cleared!";
    });

});
