<?php

namespace App\Http\Controllers;

use App\Casa;
use App\ProdusVandut;
use App\Avans;
use App\Plata;
use DB;
use Illuminate\Http\Request;

class CasaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_data_inceput = \Request::get('search_data_inceput'); //<-- we use global request to get the param of URI 
        $search_data_sfarsit = \Request::get('search_data_sfarsit'); //<-- we use global request to get the param of URI 

        $casa = Casa::
            when($search_data_inceput, function ($query, $search_data_inceput) {
                return $query->whereDate('casa.created_at', '>=', $search_data_inceput);
            })
            ->when($search_data_sfarsit, function ($query, $search_data_sfarsit) {
                return $query->whereDate('casa.created_at', '>=', $search_data_sfarsit);
            })
            ->latest()
            ->simplePaginate(25);
        
        if ($casa->isNotEmpty()) {
            $suma['produse_vandute'] = ProdusVandut::where('created_at', '>', $casa->first()->created_at)
                ->whereNull('card')
                ->whereNull('emag')
                ->sum(DB::raw('cantitate * pret'));
            $suma['avansuri'] = Avans::where('created_at', '>', $casa->first()->created_at)->sum('suma');
            $suma['plati'] = Plata::where('created_at', '>', $casa->first()->created_at)->sum('suma');
            $suma['suma_totala'] = $casa->first()->suma + $suma['produse_vandute'] + $suma['avansuri'] - $suma['plati'];
        } else{
            $suma = [
                'produse_vandute' => 0,
                'avansuri' => 0,
                'plati' => 0,
                'suma_totala' => 0,
            ];
        }

        return view('casa.index', compact('casa', 'search_data_inceput', 'search_data_sfarsit', 'suma'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('casa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $casa = Casa::make($this->validateRequest());
        $casa->user_id = auth()->user()->id;
        // $this->authorize('update', $proiecte);
        $casa->save();

        return redirect('/casa')->with('status', 'Casa a fost setată cu suma "'.$casa->suma.'"!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Casa  $casa
     * @return \Illuminate\Http\Response
     */
    public function show(Casa $casa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Casa  $casa
     * @return \Illuminate\Http\Response
     */
    public function edit(Casa $casa)
    {
        return view('casa.edit', compact('casa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Casa  $casa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Casa $casa)
    {
        // $this->authorize('update', $proiecte);

        $casa->update($this->validateRequest($casa));

        return redirect('/casa')->with('status', 'Setarea sumei Casei a fost modificată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Casa  $casa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Casa $casa)
    {
        $casa->delete();
        return redirect('/casa')->with('status', 'Setarea sumei Casei a fost ștearsă cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest()
    {
        return request()->validate([
            'suma' => ['required', 'numeric', 'between:0.00,99999.99'],
        ]
        );
    }
}
