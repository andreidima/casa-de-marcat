<?php

namespace App\Http\Controllers;

use App\Factura;
use App\Client;
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
        $search_numar = \Request::get('search_numar'); //<-- we use global request to get the param of URI 
        $facturi = Factura::
            with('produse')
            ->when($search_firma, function ($query, $search_firma) {
                return $query->where('firma', 'like', '%' . str_replace(' ', '%', $search_firma) . '%');
            })
            ->when($search_numar, function ($query, $search_numar) {
                return $query->where('numar', $search_numar);
            })
            ->latest()
            ->simplePaginate(25);
        $ultima_factura = Factura::select('numar')->max('numar');

        return view('facturi.index', compact('facturi', 'ultima_factura', 'search_firma', 'search_numar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clienti = \App\Client::all();
        $clienti = $clienti->sortBy('firma')->values();

        return view('facturi.create', compact('clienti'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client = Client::where('id', $request->client_deja_inregistrat)->first();
        if (isset($client)){
            $client->update($this->validateRequest());
        } else {
            $client = Client::make($this->validateRequest());
            $client->save();
        }

        $facturi = Factura::make($this->validateRequest());
        $facturi->client_id = $client->id;
        $facturi->seria = 'VNGSM';
        $facturi->numar = is_null(\App\Factura::select('numar')->max('numar')) ? 681 : (\App\Factura::select('numar')->max('numar') + 1);
        $facturi->save();

        return redirect('/facturi')->with('status', 'Factura "'.$facturi->seria.$facturi->numar.'" a fost înregistrată cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function show(Factura $facturi)
    {
        return view('facturi.show', compact('facturi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function edit(Factura $facturi)
    {
        $clienti = \App\Client::all();
        $clienti = $clienti->sortBy('firma')->values();

        return view('facturi.edit', compact('facturi', 'clienti'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Factura $facturi)
    {
        // dd($request, $request->client_deja_inregistrat);
        $facturi->update($this->validateRequest($facturi));

        $client = Client::where('id', $request->client_deja_inregistrat)->first();
        if (isset($client)) {
            $client->update($this->validateRequest());
            // dd($request->client_deja_inregistrat, $client);
        } else {
            $client = Client::make($this->validateRequest());
            $client->save();
        }

        return redirect('/facturi')->with('status', 'Factura "'.$facturi->seria.$facturi->numar.'" a fost modificată cu succes!');
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

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest()
    {
        return request()->validate([
            'client_id' =>['nullable'],
            'firma' =>['nullable', 'max:250'],
            'nr_reg_com' =>['nullable', 'max:250'],
            'cif_cnp' =>['nullable', 'max:250'],
            'adresa' =>['nullable', 'max:250'],
            'delegat' =>['nullable', 'max:250'],
            'seria_nr_buletin' =>['nullable', 'max:250'],
            'telefon' =>['nullable', 'max:250'],
            'seria' =>['nullable', 'max:20'],
            'numar' =>['nullable', 'numeric', 'between:0.00,99999.99'],
        ]
        );
    }
}
