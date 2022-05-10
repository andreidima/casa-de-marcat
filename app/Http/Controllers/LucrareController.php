<?php

namespace App\Http\Controllers;

use App\Lucrare;
use Illuminate\Http\Request;

class LucrareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search_categorie = $request->search_categorie;
        $search_producator = $request->search_producator;
        $search_model = $request->search_model;
        $search_problema = $request->search_problema;

        $lucrari = Lucrare::
            when($search_categorie, function ($query, $search_categorie) {
                return $query->where('categorie', 'like', '%' . $search_categorie . '%');
            })
            ->when($search_producator, function ($query, $search_producator) {
                return $query->where('producator', 'like', '%' . $search_producator . '%');
            })
            ->when($search_model, function ($query, $search_model) {
                return $query->where('model', 'like', '%' . $search_model . '%');
            })
            ->when($search_problema, function ($query, $search_problema) {
                return $query->where('problema', 'like', '%' . $search_problema . '%');
            })
            ->latest()
            ->simplePaginate(25);

        return view('lucrari.index', compact('lucrari', 'search_categorie', 'search_producator', 'search_model', 'search_problema'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lucrari.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lucrare = Lucrare::create($this->validateRequest());

        return redirect('/lucrari')->with('status', 'Lucrarea „' . $lucrare->problema . '” a fost adaugată cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lucrare  $lucrare
     * @return \Illuminate\Http\Response
     */
    public function show(Lucrare $lucrare)
    {
        return view('lucrari.show', compact('lucrare'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lucrare  $lucrare
     * @return \Illuminate\Http\Response
     */
    public function edit(Lucrare $lucrare)
    {
        return view('lucrari.edit', compact('lucrare'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lucrare  $lucrare
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lucrare $lucrare)
    {
        $lucrare->update($this->validateRequest($request));

        return redirect('/lucrari')->with('status', 'Lucrarea „' . $lucrare->problema . '” a fost modificată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lucrare  $lucrare
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lucrare $lucrare)
    {
        $lucrare->delete();
        return redirect('/lucrari')->with('status', 'Lucrarea „' . $lucrare->problema . '" a fost ștearsă cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest()
    {
        return request()->validate([
            'categorie' => 'required|max:200',
            'producator' => 'required|max:200',
            'model' => 'required|max:200',
            'problema' => 'required|max:200',
            'pret' => 'required|integer|between:1,99999',
        ]
        );
    }

    public function vizualizare()
    {
        $lucrari = Lucrare::all();
        return view('lucrari.diverse.vizualizare', compact('lucrari'));
    }
}
