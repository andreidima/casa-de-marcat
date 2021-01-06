<?php

use Illuminate\Database\Eloquent\Builder;

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

    // Route::any('setare-niruri-la-produse-stocuri', function () {
        
        // $produse_stocuri_telefoane_noi = \App\ProdusStoc::
        //     whereDoesntHave('nir')
        //     ->whereHas('produs', function (Builder $query) {
        //         $query->whereHas('subcategorie', function (Builder $query){
        //             $query->where('categorie_produs_id', 1);
        //         });
        //     })
        //     ->where('fara_nir', 0)
        //     ->latest()
        //     ->get();

        // $produse_stocuri_accesorii = \App\ProdusStoc::
        //     whereDoesntHave('nir')
        //     ->whereHas('produs', function (Builder $query) {
        //         $query->whereHas('subcategorie', function (Builder $query){
        //             $query->where('categorie_produs_id', 3);
        //         });
        //     })
        //     ->where('fara_nir', 0)
        //     ->latest()
        //     ->get();
        
        // $produse_stocuri_telefoane_noi_fara_nir = \App\ProdusStoc::
        //     // whereDoesntHave('nir')
        //     whereHas('produs', function (Builder $query) {
        //         $query->whereHas('subcategorie', function (Builder $query){
        //             $query->where('categorie_produs_id', 1);
        //         });
        //     })
        //     ->where('fara_nir', 1)
        //     ->latest()
        //     ->get();

        // $produse_stocuri_accesorii_fara_nir = \App\ProdusStoc::
        //     // whereDoesntHave('nir')
        //     whereHas('produs', function (Builder $query) {
        //         $query->whereHas('subcategorie', function (Builder $query){
        //             $query->where('categorie_produs_id', 3);
        //         });
        //     })
        //     ->where('fara_nir', 1)
        //     ->latest()
        //     ->get();
        
        // $produse_stocuri_telefoane_noi_cu_nir_generat = \App\ProdusStoc::
        //     whereHas('nir')
        //     ->whereHas('produs', function (Builder $query) {
        //         $query->whereHas('subcategorie', function (Builder $query){
        //             $query->where('categorie_produs_id', 1);
        //         });
        //     })
        //     ->where('fara_nir', 0)
        //     ->latest()
        //     ->get();

        // $produse_stocuri_accesorii_cu_nir_generat = \App\ProdusStoc::
        //     whereHas('nir')
        //     ->whereHas('produs', function (Builder $query) {
        //         $query->whereHas('subcategorie', function (Builder $query){
        //             $query->where('categorie_produs_id', 3);
        //         });
        //     })
        //     ->where('fara_nir', 0)
        //     ->latest()
        //     ->get();

        // $produse_stocuri_alte_categorii = \App\ProdusStoc::
        //     // whereHas('nir')
        //     whereHas('produs', function (Builder $query) {
        //         $query->whereHas('subcategorie', function (Builder $query){
        //             $query->where('categorie_produs_id', 2)
        //                 ->orwhere('categorie_produs_id', 4);
        //         });
        //     })
        //     ->latest()
        //     ->get();

        // $produse_stocuri = \App\ProdusStoc::
        //     // whereHas('nir')
        //     latest()
        //     ->get();

        // $produse_stocuri_fara_produs = \App\ProdusStoc::
        //     // whereHas('nir')
        //     whereDoesntHave('produs')
        //     ->latest()
        //     ->get();
        
        // echo 
        //     '' . $produse_stocuri_telefoane_noi->count() . '<br>' .
        //     '' . $produse_stocuri_accesorii->count() . '<br>' .
        //     '' . $produse_stocuri_telefoane_noi_fara_nir->count() . '<br>' .
        //     '' . $produse_stocuri_accesorii_fara_nir->count() . '<br>' .
        //     '' . $produse_stocuri_telefoane_noi_cu_nir_generat->count()  . '<br>' .
        //     '' . $produse_stocuri_accesorii_cu_nir_generat->count() . '<br>' .
        //     '' . $produse_stocuri_alte_categorii->count() . '<br>' .
        //     '' . $produse_stocuri->count() . '<br>' .
        //     '' . $produse_stocuri_fara_produs->count() . '<br>' .
        //     'Total = ' . 
        //         (
        //             $produse_stocuri_telefoane_noi->count() +
        //             $produse_stocuri_accesorii->count() + 
        //             $produse_stocuri_telefoane_noi_fara_nir->count() + 
        //             $produse_stocuri_accesorii_fara_nir->count() + 
        //             $produse_stocuri_telefoane_noi_cu_nir_generat->count() + 
        //             $produse_stocuri_accesorii_cu_nir_generat->count() + 
        //             $produse_stocuri_alte_categorii->count()
        //         )
        //     ;

            

        // $produse_stocuri_cu_nir = \App\ProdusStoc::whereHas('nir')
        //     ->with('nir')
        //     ->select ('id', 'nir_id')
        //     ->where('fara_nir', 0)
        //     ->orderBy('id')
        //     ->get();

        // $produse_stocuri_cu_nir_lipsa = \App\ProdusStoc::whereDoesntHave('nir')
        //     ->select('id', 'nir_id')
        //     ->where('fara_nir', 0)
        //     ->orderBy('id')
        //     ->get();

        // $produse_stocuri_fara_nir = \App\ProdusStoc::with('nir')
        //     ->select('id', 'nir_id')
        //     ->where('fara_nir', 1)
        //     ->orderBy('id')
        //     ->get();

        // dd($produse_stocuri_cu_nir->count(), $produse_stocuri_cu_nir_lipsa, $produse_stocuri_fara_nir->count(), $produse_stocuri_cu_nir->count() + $produse_stocuri_fara_nir->count());

        // foreach ($produse_stocuri_cu_nir as $produs_stoc){
        //     $produs_stoc->nir_id = $produs_stoc->nir->id;
        //     $produs_stoc->save();

        //     echo $produs_stoc->id . ' . ';
        // }
        // return ;
        // dd($produse_stocuri);
        // echo 'Gata';
    // });
});
