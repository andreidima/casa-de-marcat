<?php

namespace App\Http\Controllers;

use App\ProdusStoc;
use Illuminate\Http\Request;

class ProdusStocController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_produs_nume = \Request::get('search_nume'); //<-- we use global request to get the param of URI  
        $stocuri = ProdusStoc::
            when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . str_replace(' ', '%', $search_nume) . '%');
            })
            ->latest()
            ->Paginate(25);

        return view('avansuri.index', compact('avansuri', 'search_nume'));
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
     * @param  \App\ProdusStoc  $produsStoc
     * @return \Illuminate\Http\Response
     */
    public function show(ProdusStoc $produsStoc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProdusStoc  $produsStoc
     * @return \Illuminate\Http\Response
     */
    public function edit(ProdusStoc $produsStoc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProdusStoc  $produsStoc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProdusStoc $produsStoc)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProdusStoc  $produsStoc
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProdusStoc $produsStoc)
    {
        //
    }
}
