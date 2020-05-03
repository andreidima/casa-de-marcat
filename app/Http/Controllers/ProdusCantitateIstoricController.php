<?php

namespace App\Http\Controllers;

use App\ProdusCantitateIstoric;
use DB;
use Illuminate\Http\Request;

class ProdusCantitateIstoricController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_produs = \Request::get('search_produs'); //<-- we use global request to get the param of URI  
        $search_furnizor = \Request::get('search_furnizor'); //<-- we use global request to get the param of URI  

        $stocuri = ProdusCantitateIstoric::
            // DB::table('produse_cantitati_istoric')
            leftJoin('produse', 'produse_cantitati_istoric.produs_id', '=', 'produse.id')
            ->leftJoin('furnizori', 'produse_cantitati_istoric.furnizor_id', '=', 'furnizori.id')
            // ->leftJoin('subcategorii_produse', 'produse.subcategorie_produs_id', '=', 'subcategorii_produse.id')
            // ->leftJoin('categorii_produse', 'subcategorii_produse.categorie_produs_id', '=', 'categorii_produse.id')
            ->select(DB::raw('
                            produse_cantitati_istoric.id as produse_cantitati_istoric_id,
                            ifnull(produse_cantitati_istoric.cantitate_initiala, 0) as cantitate_initiala,
                            produse_cantitati_istoric.cantitate as cantitate,
                            produse_cantitati_istoric.operatiune,
                            produse_cantitati_istoric.created_at,
                            produse.nume as produs_nume,
                            furnizori.nume as furnizor_nume
                    '))
            // ->whereDate('produse_cantitati_istoric.created_at', $search_data)
            // ->when($search_nume, function ($query, $search_nume) {
            //     return $query->where('nume', 'like', '%' . str_replace(' ', '%', $search_nume) . '%');
            // })
            ->where(function ($query) {
                    $query->where('produse_cantitati_istoric.operatiune', 'adaugare')
                        ->orWhere('produse_cantitati_istoric.operatiune', 'modificare')
                        ->orWhere('produse_cantitati_istoric.operatiune', 'suplimentare stoc');
                })
            ->latest()
            ->simplePaginate(25);

            // dd($stocuri);

            // when($search_produs, function ($query, $search_produs) {
            //         return $query->where('nume', 'like', '%' . str_replace(' ', '%', $search_nume) . '%');
            //     })
            // ->latest()
            // ->Paginate(25);

        return view('stocuri.index', compact('stocuri', 'search_produs', 'search_furnizor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProdusCantitateIstoric  $produsCantitateIstoric
     * @return \Illuminate\Http\Response
     */
    public function show(ProdusCantitateIstoric $produsCantitateIstoric)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProdusCantitateIstoric  $produsCantitateIstoric
     * @return \Illuminate\Http\Response
     */
    public function edit(ProdusCantitateIstoric $produsCantitateIstoric)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProdusCantitateIstoric  $produsCantitateIstoric
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProdusCantitateIstoric $produsCantitateIstoric)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProdusCantitateIstoric  $produsCantitateIstoric
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProdusCantitateIstoric $produsCantitateIstoric)
    {
        //
    }
}
