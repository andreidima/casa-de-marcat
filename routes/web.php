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

    Route::any('produse-fara-nir', function () {
        // $produse = \App\Produs::where('cantitate', '>', 0)->get();
        // $produse_cu_stocuri = \App\Produs::where('cantitate', '>', 0)->whereHas('produse_stocuri')->get();
        // $produse_fara_stocuri = \App\Produs::where('cantitate', '>', 0)->whereDoesntHave('produse_stocuri')->get();

        // echo 
        //     'Produse = ' . $produse->count() . '<br>' .
        //     'Produse cu stocuri = ' . $produse_cu_stocuri->count() . '<br>' .
        //     'Produse fara stocuri= ' . $produse_fara_stocuri->count() . '<br>' 
        //     ;

        // foreach ($produse_fara_stocuri as $produs){
        //     echo $produs->nume . '<br>';
        // }
        
        // $stocuri = \App\ProdusStoc::get();
        // echo 
        //     'Stocuri = ' . $stocuri->count() . '<br>' .
        //     'Stocuri cu nir = ' . $stocuri->where('fara_nir', 0)->count() . '<br>' .
        //     'Stocuri fara nir = ' . $stocuri->where('fara_nir', 1)->count() . '<br>'            
        //     ;
        
        // foreach($stocuri->where('fara_nir', 0) as $stoc_cu_nir){
        //     foreach($stocuri->where('fara_nir', 1) as $stoc_fara_nir){
        //         if ($stoc_cu_nir->produs_id == $stoc_fara_nir->produs_id){
        //             echo 'Produs id = ' . $stoc_cu_nir->produs_id . ' | ' . 'Stocuri id = ' . $stoc_cu_nir->id . ' , ' . $stoc_fara_nir->id . '<br>';
        //         }
        //     }
        // }

        $produse = \App\Produs::where('produse.cantitate', '>', 0)
            ->leftJoin('produse_stocuri', 'produse.id', '=', 'produse_stocuri.produs_id')
            ->select(
                'produse.id as produs_id', 
                'produse_stocuri.id as stoc_id', 
                'produse.cantitate as cantitate_totala', 
                'produse_stocuri.cantitate as cantitate',
                'produse_stocuri.created_at as created_at'
                )
            ->orderBy('produs_id', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        // echo
        //     $produse->count() . 
        //     '<br><br>'
        //     ;

        foreach($produse->groupBy('produs_id') as $produs){
            echo 
                'Id produs = ' . $produs->first()->produs_id . '<br>' . 
                'Cantitate produs = ' . $produs->first()->cantitate_totala . '<br>'
                ;
            foreach($produs as $stoc){
                echo 
                    'Cantitate stoc = ' . $stoc->cantitate . '<br>'
                    ;
            }
            echo 
                '<br><br>'
                ;
            // echo $produs->produs_id . ' ';
        }

        // echo 
        //     'Produse = ' . $produse->count() . '<br>'
            // 'Stocuri cu nir = ' . $stocuri->where('fara_nir', 0)->count() . '<br>' .
            // 'Stocuri fara nir = ' . $stocuri->where('fara_nir', 1)->count() . '<br>'            
            ;

        // $stocuri = \App\ProdusStoc::join('produse', 'produs_id', '=', 'produse.id')
        //     ->select('produse_stocuri.id as id', 'produs_id', 'produse.cantitate as cantitate_totala', 'produse_stocuri.cantitate as cantitate')
        //     ->get();
        // echo 
        //     'Stocuri = ' . $stocuri->count() . '<br>' .
        //     'Stocuri cu nir = ' . $stocuri->where('fara_nir', 0)->count() . '<br>' .
        //     'Stocuri fara nir = ' . $stocuri->where('fara_nir', 1)->count() . '<br>'            
        //     ;
        
        // foreach($stocuri as $stoc){
        //     echo 'Produs id = ' . $stoc->produs_id . ' | ' . 'Cantitate totala = ' . $stoc->cantitate_totala . ' , ' . $stoc->cantitate . '<br>';
        // }

    });


    
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


    // De sters intreaga ruta la 01.02.2021
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
