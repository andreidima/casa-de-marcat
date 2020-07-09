<?php

namespace App\Http\Controllers;

use App\FacturaProdus;
use App\Factura;
use Illuminate\Http\Request;

class FacturaProdusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Factura $facturi)
    {
        return view('facturi-produse.create', compact('facturi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Factura $facturi)
    {
        $facturi_produse = FacturaProdus::make($this->validateRequest());
        $facturi_produse->factura_id = $facturi->id;
        $facturi_produse->save();

        return redirect('/facturi')->with('status', 'Produsul ' . $facturi_produse->nume . ' a fost adăugat la factura ' . $facturi->seria . $facturi->numar);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FacturaProdus  $facturaProdus
     * @return \Illuminate\Http\Response
     */
    public function show(FacturaProdus $facturaProdus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FacturaProdus  $facturaProdus
     * @return \Illuminate\Http\Response
     */
    public function edit(Factura $facturi, FacturaProdus $facturi_produse)
    {
        return view('facturi-produse.edit', compact('facturi', 'facturi_produse'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FacturaProdus  $facturaProdus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Factura $facturi, FacturaProdus $facturi_produse)
    {
        $facturi_produse->update($this->validateRequest($facturi_produse));

        return redirect('/facturi')->with('status', 'Produsul din factură a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FacturaProdus  $facturaProdus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Factura $facturi, FacturaProdus $facturi_produse)
    {
        $facturi_produse->delete();
        return redirect('/facturi')->with('status', 'Produsul din factură a fost șters cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest()
    {
        return request()->validate([
            // 'factura_id' => ['required'],
            'nume' => ['nullable', 'max:250'],
            'um' => ['nullable', 'max:250'],
            'cantitate' => ['nullable', 'numeric', 'between:0,999999999'],
            'pret_unitar' => ['nullable', 'numeric', 'between:-999999,99999.99'],
            'valoare' => ['nullable', 'numeric', 'between:-999999,99999.99'],
            'valoare_tva' => ['nullable', 'numeric', 'between:-999999,99999.99'],
            'observatii' => ['nullable', 'max:250'],
        ]);
    }
}
