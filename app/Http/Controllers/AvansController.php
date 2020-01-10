<?php

namespace App\Http\Controllers;

use App\Avans;
use Illuminate\Http\Request;

class AvansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $search_nume = \Request::get('search_nume'); //<-- we use global request to get the param of URI  
        $avansuri = Avans::
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
        return view('avansuri.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $avansuri = Avans::make($this->validateRequest());
        // $this->authorize('update', $proiecte);
        $avansuri->stare = 1;
        $avansuri->save();

        return redirect('/avansuri')->with('status', 'Avansul pentru clientul "'.$avansuri->nume.'" a fost înregistrat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Avans  $avans
     * @return \Illuminate\Http\Response
     */
    public function show(Avans $avansuri)
    {
        return view('avansuri.show', compact('avansuri'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Avans  $avans
     * @return \Illuminate\Http\Response
     */
    public function edit(Avans $avansuri)
    {
        return view('avansuri.edit', compact('avansuri'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Avans  $avans
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Avans $avansuri)
    {
        // $this->authorize('update', $proiecte);

        $avansuri->update($this->validateRequest($avansuri));

        return redirect('/avansuri')->with('status', 'Avansul pentru clientul "'.$avansuri->nume.'" a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Avans  $avans
     * @return \Illuminate\Http\Response
     */
    public function destroy(Avans $avansuri)
    {
        $avansuri->delete();
        return redirect('/avansuri')->with('status', 'Avansul pentru clientul "' . $avansuri->nume . '" a fost șters cu succes!');
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

    public function update_deschis_inchis(Request $request, Avans $avansuri)
    {
        if ( $avansuri->stare === '0') {
            $avansuri->stare = 1;
        } else {
            $avansuri->stare = 0;
        }
        $avansuri->update();
        
        return redirect('/avansuri');
    }
}
