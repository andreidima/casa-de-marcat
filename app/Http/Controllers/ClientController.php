<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $search_firma = \Request::get('search_firma'); //<-- we use global request to get the param of URI  
        $clienti = Client::
            when($search_firma, function ($query, $search_firma) {
                return $query->where('firma', 'like', '%' . str_replace(' ', '%', $search_firma) . '%');
            })
            ->latest()
            ->simplePaginate(25);

        return view('clienti.index', compact('clienti', 'search_firma'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clienti.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $clienti = Client::make($this->validateRequest());
        // $this->authorize('update', $proiecte);
        $clienti->save();

        return redirect('/clienti')->with('status', 'Clientul "' . $clienti->firma . '" a fost înregistrat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $avans
     * @return \Illuminate\Http\Response
     */
    public function show(Client $clienti)
    {
        return view('clienti.show', compact('clienti'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $avans
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $clienti)
    {
        return view('clienti.edit', compact('clienti'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $avans
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $clienti)
    {
        // $this->authorize('update', $proiecte);

        $clienti->update($this->validateRequest($clienti));

        return redirect('/clienti')->with('status', 'Client "'.$clienti->firma.'" a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $avans
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $clienti)
    {
        $clienti->delete();
        return redirect('/clienti')->with('status', 'Clientul "' . $clienti->firma . '" a fost șters cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest()
    {
        return request()->validate([
            'firma' => ['nullable', 'max:200'],
            'nr_reg_com' => ['nullable', 'max:200'],
            'cif_cnp' => ['nullable', 'max:200'],
            'adresa' => ['nullable', 'max:200'],
            'delegat' => ['nullable', 'max:200'],
            'seria_nr_buletin' => ['nullable', 'max:200'],
            'telefon' => ['nullable', 'max:200']
        ]
        );
    }
}
