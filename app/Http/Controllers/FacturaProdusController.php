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
    public function create(Factura $factura)
    {
        return view('facturi-produse.create', compact('factura'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $facturi_produse = Plata::make($this->validateRequest());
        // $this->authorize('update', $proiecte);
        $facturi_produse->save();

        return redirect('/facturi_produse')->with('status', 'Produsul din factură a fost înregistrat cu succes!');
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
    public function edit(FacturaProdus $facturi_produse)
    {
        return view('facturi_produse.edit', compact('facturi_produse'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FacturaProdus  $facturaProdus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FacturaProdus $facturi_produse)
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
    public function destroy(FacturaProdus $facturi_produse)
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
            'factura_id' => ['required'],
            'nume' => ['required', 'max:250'],
            'um' => ['required', 'max:250'],
            'cantitate' => ['required', 'numeric', 'between:0,999999999'],
            'pret_unitar' => ['required', 'numeric', 'between:0.01,99999.99'],
            'valoare' => ['required', 'numeric', 'between:0.01,99999.99'],
            'valoare_tva' => ['required', 'numeric', 'between:0.01,99999.99'],
        ]);
    }
}
