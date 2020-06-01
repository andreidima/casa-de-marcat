<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class NirController extends Controller
{

    /**
     * Pagina principala Nir.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $search_data = \Request::get('search_data'); //<-- we use global request to get the param of URI
        $search_nume = \Request::get('search_nume');      
        
        $search_data = $search_data ?? \Carbon\Carbon::today();

        // $produse_intrate = DB::table('produse_cantitati_istoric')
        //     ->leftJoin('produse', 'produse_cantitati_istoric.produs_id', '=', 'produse.id')
        //     // ->leftJoin('subcategorii_produse', 'produse.subcategorie_produs_id', '=', 'subcategorii_produse.id')
        //     // ->leftJoin('categorii_produse', 'subcategorii_produse.categorie_produs_id', '=', 'categorii_produse.id')
        //     ->select(DB::raw('
        //                     produse_cantitati_istoric.id as produse_cantitati_istoric_id,
        //                     ifnull(produse_cantitati_istoric.cantitate_initiala, 0) as cantitate_initiala,
        //                     produse_cantitati_istoric.cantitate as cantitate,
        //                     produse_cantitati_istoric.operatiune,
        //                     produse_cantitati_istoric.created_at,
        //                     produse.id as produs_id,
        //                     produse.nume,
        //                     produse.pret_de_achizitie,
        //                     produse.pret,
        //                     round(
        //                             (produse_cantitati_istoric.cantitate - ifnull(produse_cantitati_istoric.cantitate_initiala, 0)) * 
        //                             (produse.pret_de_achizitie / 1.19) 
        //                         , 2) as total_suma_achizitie,
        //                     round(
        //                             (produse_cantitati_istoric.cantitate - ifnull(produse_cantitati_istoric.cantitate_initiala, 0)) * 
        //                             (produse.pret_de_achizitie * 0.19)
        //                         , 2) as total_suma_tva,
        //                     round(
        //                             (produse_cantitati_istoric.cantitate - ifnull(produse_cantitati_istoric.cantitate_initiala, 0)) * 
        //                             produse.pret
        //                         , 2) as total_suma_vanzare
        //             '))
        //     ->whereDate('produse_cantitati_istoric.created_at', $search_data)
        //     ->when($search_nume, function ($query, $search_nume) {
        //             return $query->where('nume', 'like', '%' . str_replace(' ', '%', $search_nume) . '%');
        //         })
        //     ->where(function ($query) {
        //         $query->where('produse_cantitati_istoric.operatiune', 'adaugare')
        //               ->orWhere('produse_cantitati_istoric.operatiune', 'modificare')
        //               ->orWhere('produse_cantitati_istoric.operatiune', 'suplimentare stoc');
        //     })
        //     ->orderBy('nume')
        //     ->get();

        $produse_intrate = DB::table('produse_stocuri')
            ->leftJoin('produse', 'produse_stocuri.produs_id', '=', 'produse.id')
            ->select(DB::raw('
                            produse_cantitati_istoric.id as produse_cantitati_istoric_id,
                            ifnull(produse_cantitati_istoric.cantitate_initiala, 0) as cantitate_initiala,
                            produse_cantitati_istoric.cantitate as cantitate,
                            produse_cantitati_istoric.operatiune,
                            produse_cantitati_istoric.created_at,
                            produse.id as produs_id,
                            produse.nume,
                            produse.pret_de_achizitie,
                            produse.pret,
                            round(
                                    (produse_cantitati_istoric.cantitate - ifnull(produse_cantitati_istoric.cantitate_initiala, 0)) * 
                                    (produse.pret_de_achizitie / 1.19) 
                                , 2) as total_suma_achizitie,
                            round(
                                    (produse_cantitati_istoric.cantitate - ifnull(produse_cantitati_istoric.cantitate_initiala, 0)) * 
                                    (produse.pret_de_achizitie * 0.19)
                                , 2) as total_suma_tva,
                            round(
                                    (produse_cantitati_istoric.cantitate - ifnull(produse_cantitati_istoric.cantitate_initiala, 0)) * 
                                    produse.pret
                                , 2) as total_suma_vanzare
                    '))
            ->whereDate('produse_stocuri.created_at', $search_data)
            ->when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . str_replace(' ', '%', $search_nume) . '%');
            })
            ->orderBy('nume')
            ->get();

        // dd($search_data);
        // dd($produse_intrate);

        return view('nir.index', compact('produse_intrate', 'search_data', 'search_nume'));
    }

    public function pdfExport(Request $request, $search_data)
    {
        $search_data = $search_data ?? \Carbon\Carbon::today();

        $produse_intrate = DB::table('produse_cantitati_istoric')
            ->leftJoin('produse', 'produse_cantitati_istoric.produs_id', '=', 'produse.id')
            // ->leftJoin('subcategorii_produse', 'produse.subcategorie_produs_id', '=', 'subcategorii_produse.id')
            // ->leftJoin('categorii_produse', 'subcategorii_produse.categorie_produs_id', '=', 'categorii_produse.id')
            ->select(DB::raw('
                        produse_cantitati_istoric.id as produse_cantitati_istoric_id,
                        ifnull(produse_cantitati_istoric.cantitate_initiala, 0) as cantitate_initiala,
                        produse_cantitati_istoric.cantitate as cantitate,
                        produse_cantitati_istoric.operatiune,
                        produse_cantitati_istoric.created_at,
                        produse.id as produs_id,
                        produse.nume,
                        produse.pret_de_achizitie,
                        produse.pret,
                        round(
                                (produse_cantitati_istoric.cantitate - ifnull(produse_cantitati_istoric.cantitate_initiala, 0)) * 
                                (produse.pret_de_achizitie / 1.19) 
                            , 2) as total_suma_achizitie,
                        round(
                                (produse_cantitati_istoric.cantitate - ifnull(produse_cantitati_istoric.cantitate_initiala, 0)) * 
                                (produse.pret_de_achizitie * 0.19)
                            , 2) as total_suma_tva,
                        round(
                                (produse_cantitati_istoric.cantitate - ifnull(produse_cantitati_istoric.cantitate_initiala, 0)) * 
                                produse.pret
                            , 2) as total_suma_vanzare
                '))
            ->whereDate('produse_cantitati_istoric.created_at', $search_data)
            ->where(function ($query) {
                $query->where('produse_cantitati_istoric.operatiune', 'adaugare')
                    ->orWhere('produse_cantitati_istoric.operatiune', 'modificare')
                    ->orWhere('produse_cantitati_istoric.operatiune', 'suplimentare stoc');
            })
            ->orderBy('nume')
            ->get();

        if ($request->view_type === 'raport-html') {
            return view(
                'nir.export.nir-pdf',
                compact('produse_intrate', 'search_data')
            );
        } elseif ($request->view_type === 'raport-pdf') {
            $pdf = \PDF::loadView(
                'nir.export.nir-pdf',
                compact('produse_intrate', 'search_data')
            )
                ->setPaper('a4', 'landscape');
            return $pdf->stream('Nir ' .
                \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') . '.pdf');
        }
    }
}
