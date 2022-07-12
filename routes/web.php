<?php

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

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
    // Pagina de statistică
    Route::any('/produse/gestiune', 'ProdusController@gestiune');
    // Readaugare rapida de produs
    Route::any('/produse/salvare_si_adaugare_noua', 'ProdusController@salvareSiAdaugareNoua');

    // Rute pentru rapoarte
    Route::get('produse/rapoarte/lista-inventar/{view_type}', 'ProdusController@pdfExportListaInventar');
    Route::any('produse-vandute/rapoarte/raport-zilnic/{view_type?}', 'ProdusVandutController@rapoarteRaportZilnic');
    Route::get('produse-vandute/rapoarte/raport-zilnic/{data_traseu}/export/{view_type}', 'ProdusVandutController@pdfExportRaportZilnic');
    Route::get('produse-vandute/rapoarte/raport-zilnic/{data_traseu}/avansuri/export/{view_type}', 'ProdusVandutController@pdfExportRaportZilnicAvansuri');
    Route::get('produse-vandute/rapoarte/raport-zilnic/{data_traseu}/plati/export/{view_type}', 'ProdusVandutController@pdfExportRaportZilnicPlati');
    Route::get('produse-vandute/rapoarte/raport-zilnic/{data_traseu}/{categorie_id}/export/{view_type}', 'ProdusVandutController@pdfExportRaportZilnicPerCategorie');

    // Inchide avans dupa finalizare reparatie si predare restul de bani si produs
    Route::any('/avansuri/deschide-inchide/{avansuri}', 'AvansController@update_deschis_inchis');

    //Nir
    Route::get('niruri/produse-stocuri-fara-nir', 'NirController@produseStocuriFaraNir')->name('nir.produse-stocuri-fara-nir');
    Route::get('niruri/genereaza-nir', 'NirController@genereazaNir')->name('nir.genereaza-nir');
    Route::get('niruri/genereaza-nir-singular/{furnizor_id}/{nr_factura}', 'NirController@genereazaNirSingular')->name('nir.genereaza-nir-singular');
    Route::get('niruri/export', 'NirController@export')->name('nir.export');
    // Route::get('niruri/{data}/{view_type?}', 'NirController@pdfExport')->name('nir.pdfExport');
    Route::get('niruri/export/{view_type?}', 'NirController@pdfExport')->name('nir.pdfExport');

    // Generare factura client
    Route::get('/produse/generare-factura-client/completare-date', 'GenereazaFacturaClientController@completareDate');
    Route::post('/produse/generare-factura-client/salvare-date', 'GenereazaFacturaClientController@salvareDate');
    Route::get('/produse/generare-factura-client/{id}/{view_type}', 'GenereazaFacturaClientController@exportPDF');

    // Rutele default ale controllerului
    Route::resource('produse', 'ProdusController');
    Route::resource('stocuri', 'ProdusCantitateIstoricController');
    Route::resource('produse-vandute', 'ProdusVandutController');
    Route::resource('avansuri', 'AvansController');
    Route::resource('plati', 'PlataController');
    Route::resource('casa', 'CasaController');
    Route::resource('furnizori', 'FurnizorController');
    Route::resource('produse-stocuri', 'ProdusStocController');
    Route::resource('niruri', 'NirController');
    Route::resource('clienti', 'ClientController');
    Route::resource('facturi', 'FacturaController');
    Route::resource('facturi.facturi-produse', 'FacturaProdusController');


    Route::get('produse-inventar-verificare/goleste-lista', 'ProdusInventarVerificareController@golesteLista');
    Route::get('produse-inventar-verificare/produse-lipsa', 'ProdusInventarVerificareController@produseLipsa')->name('produse-inventar-verificare.produse-lipsa');
    Route::get('produse-inventar-verificare/produse-lipsa/export', 'ProdusInventarVerificareController@produseLipsaExport'); // linkul nu este vizibil in aplicatie
    Route::get('produse-inventar-verificare/lista-inventar/{view_type}', 'ProdusInventarVerificareController@pdfExportListaInventar');
    Route::resource('produse-inventar-verificare', 'ProdusInventarVerificareController');

    // Rute pentru rapoarte - controller separat
    Route::get('rapoarte/miscari-stocuri', 'RaportController@miscariStocuri')->name('rapoarte.miscari_stocuri');
    Route::get('rapoarte/miscari-produs', 'RaportController@miscariProdus')->name('miscari.produs');

    // Suplimentare stocuri
    Route::get('suplimenteaza-stocuri/adauga/{furnizor_id?}', 'SuplimenteazaStocController@create')->name('suplimenteaza-stocuri.create');
    Route::any('suplimenteaza-stocuri/salveaza', 'SuplimenteazaStocController@store');
    Route::get('suplimenteaza-stocuri/goleste-lista', 'SuplimenteazaStocController@golesteLista');

    //Export pentru Vali de pus produsele la vanzare pe site
    Route::get('produse/rapoarte/lista-inventar-produse-vali/{view_type}', 'ProdusController@pdfExportListaProduseVali');

    Route::get('raport-gestiune-accesorii', 'RaportGestiuneAccesoriiController@export')->name('raport-gestiune-accesorii');
    Route::get('raport-gestiune-accesorii/export/{view_type?}', 'RaportGestiuneAccesoriiController@pdfExport')->name('raport-gestiune-accesorii.pdfExport');

    Route::get('/lucrari/actualizare-preturi', 'LucrareController@actualizare_preturi'); // Actualizare date cu axios
    Route::get('/lucrari/actualizare-preturi-global', 'LucrareController@actualizarePreturiGlobal');
    Route::get('lucrari/vizualizare', 'LucrareController@vizualizare');
    Route::resource('lucrari', 'LucrareController', ['parameters' => ['lucrari' => 'lucrare']]);

    // Route::get('schimbare-automata-de-preturi', 'FunctiiAparteController@schimbareAutomataDePreturi');

    // 2 rute pentru inventar
    // Route::any('sincronizare-cantitati-live-cu-inventar', function () {
    //     $produse_lipsa = DB::table('produse')
    //         ->leftJoin('produse_inventar_verificare', 'produse_inventar_verificare.produs_id', '=', 'produse.id')
    //         ->select(DB::raw('
    //                         produse_inventar_verificare.id as produs_inventar_verificare_id,
    //                         produse.id as produs_id,
    //                         produse.subcategorie_produs_id,
    //                         produse.nume,
    //                         produse.cod_de_bare,
    //                         produse.cantitate as produs_cantitate,
    //                         produse_inventar_verificare.cantitate as produs_inventar_verificare_cantitate
    //                     '))
    //         ->whereRaw('((produse.cantitate !=0 and produse_inventar_verificare.cantitate is null) or produse.cantitate != produse_inventar_verificare.cantitate)')
    //         ->get();

    //     foreach ($produse_lipsa as $produs_lipsa){
    //         $produs = \App\Produs::where('id', $produs_lipsa->produs_id)->first();
    //         $produs->cantitate = $produs_lipsa->produs_inventar_verificare_cantitate ?? 0;
    //         $produs->update();
    //     }
    //     dd($produse_lipsa->count());
    // });

    // Route::any('verificare-sume-gestiune-cu-inventar', function () {
    //     for ($i = 1; $i <= 50; $i++) {
    //         echo $i . '. ';

    //         $suma_gestiune = \App\Produs::where('subcategorie_produs_id', $i)->sum(DB::raw('cantitate * pret'));
    //         echo $suma_gestiune;

    //         echo ' - ';

    //         $suma_inventar = \App\ProdusInventarVerificare::join('produse', 'produse_inventar_verificare.produs_id', '=', 'produse.id')
    //             ->select('produse.id', 'produse_inventar_verificare.cantitate as cantitate', 'produse.pret as pret')
    //             ->whereHas('produs', function ($query) use ($i) {
    //                 $query->where('subcategorie_produs_id', $i);
    //             })
    //             ->sum(DB::raw('produse_inventar_verificare.cantitate * produse.pret'));
    //         echo $suma_inventar;

    //         echo '<br>';
    //     }
    // });

    // Route::any('verificare', function () {
    //     $gestiune_veche = DB::table('produse_backup_03_01_2021')
    //                             ->join('subcategorii_produse', 'produse_backup_03_01_2021.subcategorie_produs_id', '=', 'subcategorii_produse.id')
    //                             ->select('produse_backup_03_01_2021.id as id',
    //                                 'produse_backup_03_01_2021.cantitate as cantitate',
    //                                 'produse_backup_03_01_2021.pret as pret',
    //                                 'produse_backup_03_01_2021.subcategorie_produs_id as subcategorie',
    //                                 'subcategorii_produse.categorie_produs_id as categorie'
    //                             )
    //                             ->where('subcategorii_produse.categorie_produs_id', '=', 3)
    //                             ->sum(DB::raw('cantitate * pret'));
    //                             // ->first();
    //     // echo $gestiune_veche;
    //     dd($gestiune_veche);

    // });

});
