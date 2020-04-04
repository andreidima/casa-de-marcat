<?php

namespace App\Http\Controllers;

use App\Furnizor;
use Illuminate\Http\Request;

class FurnizorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume'); //<-- we use global request to get the param of URI  
        $furnizori = Furnizor::when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . str_replace(' ', '%', $search_nume) . '%');
            })
            ->latest()
            ->Paginate(25);

        return view('furnizori.index', compact('furnizori', 'search_nume'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('furnizori.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $furnizori = Furnizor::make($this->validateRequest());
        // $this->authorize('update', $proiecte);
        $furnizori->save();

        return redirect('/furnizori')->with('status', 'Furnizorul "' . $furnizori->nume . '" a fost înregistrat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Furnizor  $furnizor
     * @return \Illuminate\Http\Response
     */
    public function show(Furnizor $furnizori)
    {
        return view('furnizori.show', compact('furnizori'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Furnizor  $furnizor
     * @return \Illuminate\Http\Response
     */
    public function edit(Furnizor $furnizori)
    {
        return view('furnizori.edit', compact('furnizori'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Furnizor  $furnizor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Furnizor $furnizori)
    {
        // $this->authorize('update', $proiecte);

        $furnizori->update($this->validateRequest($furnizori));

        return redirect('/furnizori')->with('status', 'Furnizorul "' . $furnizori->nume . '" a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Furnizor  $furnizor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Furnizor $furnizori)
    {
        $furnizori->delete();
        return redirect('/furnizori')->with('status', 'Furnizorul "' . $furnizori->nume . '" a fost șters cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest()
    {
        return request()->validate(
            [
                'nume' => ['required', 'max:150'],
                'localitate' => ['nullable', 'max:150'],
                'cod_fiscal' => ['nullable', 'max:150'],
            ]
        );
    }
}
