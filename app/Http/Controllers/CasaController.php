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
        $search_data_inceput = \Request::get('search_data_inceput') ?? \Carbon\Carbon::now();; //<-- we use global request to get the param of URI 
        $search_data_sfarsit = \Request::get('search_data_sfarsit') ?? \Carbon\Carbon::now();; //<-- we use global request to get the param of URI 

        // $search_data_inceput = $search_data_inceput ?? \Carbon\Carbon::now();
        // $search_data_sfarsit = $search_data_sfarsit ?? \Carbon\Carbon::now();

        $casa = DB::table('casa')
            ->leftjoin('produse_vandute', function ($join) {
                $join->on('casa.referinta_id', '=', 'produse_vandute.id')
                    ->where('casa.referinta_tabel', '=', 'produse_vandute');
            })
            ->leftJoin('produse', 'produse_vandute.produs_id', '=', 'produse.id')
            ->select(DB::raw('
                        casa.*,
                        produse_vandute.id as produs_vandut_id,
                        produse.id as produs_id,
                        produse.nume as produs_nume
                    '))
            ->whereDate('casa.created_at', '>=', $search_data_inceput)
            ->whereDate('casa.created_at', '<=', $search_data_sfarsit)
            ->latest()
            ->simplePaginate(25);
            // ->sortBy('categorie_nume')
            // ->sortBy('subcategorie_nume')
        // dd($casa);

        return view('casa.index', compact('casa', 'search_data_inceput', 'search_data_sfarsit'));
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
