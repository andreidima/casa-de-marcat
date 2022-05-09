<?php

namespace App\Http\Controllers;

use App\LucrareCategorie;
use Illuminate\Http\Request;

class LucrareCategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search_nume = $request->search_nume;
        $categorii = LucrareCategorie::
            when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            ->latest()
            ->simplePaginate(25);

        return view('lucrari.categorii.index', compact('categorii', 'search_nume'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lucrari.categorii.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categorie = LucrareCategorie::create($this->validateRequest());

        return redirect('/lucrari/categorii')->with('status', 'Categoria "'.$categorie->nume.'" a fost adaugată cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LucrareCategorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function show(LucrareCategorie $categorie)
    {
        return view('lucrari.categorii.show', compact('categorie'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LucrareCategorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function edit(LucrareCategorie $categorie)
    {
        return view('lucrari.categorii.edit', compact('categorie'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LucrareCategorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LucrareCategorie $categorie)
    {
        $categorie->update($this->validateRequest($request));

        return redirect('/lucrari/categorii')->with('status', 'Categoria "'.$categorie->nume.'" a fost modificată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LucrareCategorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function destroy(LucrareCategorie $categorie)
    {
        $categorie->delete();
        return redirect('/lucrari/categorii')->with('status', 'Categoria "' . $categorie->nume . '" a fost ștearsă cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest()
    {
        return request()->validate([
            'nume' =>['required', 'max:200']
        ]
        );
    }
}
