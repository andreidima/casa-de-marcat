<?php

namespace App\Http\Controllers;

// use App\ProdusCantitateIstoric;
use App\Produs;
use DB;

use Illuminate\Http\Request;

class RaportController extends Controller
{
    public function miscariStocuri(Request $request, $search_data_inceput = null, $search_data_sfarsit = null)
    {
        $search_data_inceput = \Request::get('search_data_inceput'); //<-- we use global request to get the param of URI 
        $search_data_sfarsit = \Request::get('search_data_sfarsit'); //<-- we use global request to get the param of URI 

        $search_data_inceput = $search_data_inceput ?? \Carbon\Carbon::now();
        $search_data_sfarsit = $search_data_sfarsit ?? \Carbon\Carbon::now();

        $miscari_stocuri = DB::table('produse_cantitati_istoric')
            ->leftJoin('produse', 'produse_cantitati_istoric.produs_id', '=', 'produse.id')
            ->leftJoin('subcategorii_produse', 'produse.subcategorie_produs_id', '=', 'subcategorii_produse.id')
            ->leftJoin('categorii_produse', 'subcategorii_produse.categorie_produs_id', '=', 'categorii_produse.id')
            ->select(DB::raw('
                        produse_cantitati_istoric.id as istoric_id,
                        produse.id as produs_id,
                        produse.nume,
                        produse_cantitati_istoric.cantitate,
                        produse_cantitati_istoric.operatiune,
                        subcategorii_produse.id as subcategorie_id,
                        subcategorii_produse.nume as subcategorie_nume,
                        categorii_produse.id as categorie_id,
                        categorii_produse.nume as categorie_nume,
                        produse_cantitati_istoric.created_at
                    '))
            // ->where('categorii_produse.id', $categorie_id)
            ->where('categorii_produse.id', '<>', 4)
            ->whereDate('produse_cantitati_istoric.created_at', '>=', $search_data_inceput)
            ->whereDate('produse_cantitati_istoric.created_at', '<=', $search_data_sfarsit)
            ->get()
            ->sortBy('categorie_nume')
            ->sortBy('subcategorie_nume');

        // dd($miscari_stocuri);

        return view('rapoarte.miscari_stocuri', compact('miscari_stocuri', 'search_data_inceput', 'search_data_sfarsit'));

        // if ($request->view_type === 'raport-html') {
        //     return view(
        //         'produse-vandute.rapoarte.export.raport-zilnic-per-categorie-pdf',
        //         compact('produse_vandute', 'search_data')
        //     );
        // } elseif ($request->view_type === 'raport-pdf') {
        //     $pdf = \PDF::loadView(
        //         'produse-vandute.rapoarte.export.raport-zilnic-per-categorie-pdf',
        //         compact('produse_vandute', 'search_data')
        //     )
        //         ->setPaper('a4');
        //     return $pdf->download('Raport produse vandute - ' . $produse_vandute->first()->categorie_nume . ' - ' .
        //         \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') . '.pdf');
        // }
    }

    public function miscariProdus(Request $request, $search_data_inceput = null, $search_data_sfarsit = null)
    {
        $search_nume = \Request::get('search_nume'); //<-- we use global request to get the param of URI   
        $produse = Produs::with('cantitati')
            ->where('nume', 'like', '%' . str_replace(' ', '%', $search_nume) . '%')
            // ->when($search_nume, function ($query, $search_nume) {
            //     return $query->where('nume', 'like', '%' . str_replace(' ', '%', $search_nume) . '%');
            // })
            ->latest()
            ->simplePaginate(25);

        return view('rapoarte.miscari-produs', compact('produse', 'search_nume'));
    }
}
