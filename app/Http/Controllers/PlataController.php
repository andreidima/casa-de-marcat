<?php

namespace App\Http\Controllers;

use App\Plata;
use Illuminate\Http\Request;

class PlataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $search_nume = \Request::get('search_nume'); //<-- we use global request to get the param of URI  
        $plati = Plata::
            when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . str_replace(' ', '%', $search_nume) . '%');
            })
            ->latest()
            ->simplePaginate(25);

        return view('plati.index', compact('plati', 'search_nume'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('plati.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $plati = Plata::make($this->validateRequest());
        // $this->authorize('update', $proiecte);
        $plati->save();

        return redirect('/plati')->with('status', 'Plata "'.$plati->nume.'" a fost înregistrată cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Plata  $avans
     * @return \Illuminate\Http\Response
     */
    public function show(Plata $plati)
    {
        return view('plati.show', compact('plati'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Plata  $avans
     * @return \Illuminate\Http\Response
     */
    public function edit(Plata $plati)
    {
        return view('plati.edit', compact('plati'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Plata  $avans
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plata $plati)
    {
        // $this->authorize('update', $proiecte);

        $plati->update($this->validateRequest($plati));

        return redirect('/plati')->with('status', 'Plata "'.$plati->nume.'" a fost modificată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Plata  $avans
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plata $plati)
    {
        $plati->delete();
        return redirect('/plati')->with('status', 'Plata "' . $plati->nume . '" a fost ștearsă cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest()
    {
        return request()->validate([
            'nume' =>['required', 'max:250'],
            'suma' => ['required', 'numeric', 'between:0.00,99999.99'],
            'descriere' => ['nullable', 'max:250'],
        ]
        );
    }
}
