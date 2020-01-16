<?php

namespace App\Http\Controllers;

use App\Casa;
use DB;
use Illuminate\Http\Request;

class CasaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_data_inceput = \Request::get('search_data_inceput'); //<-- we use global request to get the param of URI 
        $search_data_sfarsit = \Request::get('search_data_sfarsit'); //<-- we use global request to get the param of URI 

        $search_data_inceput = $search_data_inceput ?? \Carbon\Carbon::now();
        $search_data_sfarsit = $search_data_sfarsit ?? \Carbon\Carbon::now();

        $casa = DB::table('casa')
            ->leftjoin('produse_vandute', function ($join) {
                $join->on('casa.referinta_id', '=', 'produse_vandute.id')
                    ->where('referinta_tabel', '=', 'produse_vandute');
            })
            ->where('categorii_produse.id', '<>', 4)
            ->whereDate('produse_cantitati_istoric.created_at', '>=', $search_data_inceput)
            ->whereDate('produse_cantitati_istoric.created_at', '<=', $search_data_sfarsit)
            ->get()
            ->sortBy('categorie_nume')
            ->sortBy('subcategorie_nume');


        return view('rapoarte.miscari_stocuri', compact('miscari_stocuri', 'search_data_inceput', 'search_data_sfarsit'));
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
     * @param  \App\Casa  $casa
     * @return \Illuminate\Http\Response
     */
    public function show(Casa $casa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Casa  $casa
     * @return \Illuminate\Http\Response
     */
    public function edit(Casa $casa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Casa  $casa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Casa $casa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Casa  $casa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Casa $casa)
    {
        //
    }
}
