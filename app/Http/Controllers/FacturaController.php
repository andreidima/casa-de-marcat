<?php

namespace App\Http\Controllers;

use App\Factura;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_firma = \Request::get('search_firma'); //<-- we use global request to get the param of URI  
        $facturi = Factura::
            when($search_firma, function ($query, $search_firma) {
                return $query->where('firma', 'like', '%' . str_replace(' ', '%', $search_firma) . '%');
            })
            ->latest()
            ->simplePaginate(25);

        return view('facturi.index', compact('facturi', 'search_firma'));
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
     * @param  \App\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function show(Factura $factura)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function edit(Factura $factura)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Factura $factura)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function destroy(Factura $facturi)
    {
        if ($facturi->numar === Factura::select('numar')->max('numar'))
        {
            $facturi->delete();
        }
        return redirect('/facturi')->with('status', 'Factura "' . $facturi->seria . ' ' . $facturi->numar . '" a fost ștearsă cu succes!');
    }
}
