<?php

namespace App\Http\Controllers;

use App\Produs;
use Illuminate\Http\Request;

class ProdusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_cod_de_bare = \Request::get('search_cod_de_bare'); //<-- we use global request to get the param of URI        
        $produse = Produs::
                when($search_cod_de_bare, function ($query, $search_cod_de_bare) {
                    return $query->where('cod_de_bare', 'like', '%' . $search_cod_de_bare . '%');
                })
            ->latest()
            ->Paginate(25);
                
        return view('produse.index', compact('produse'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('produse.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $produse = Produs::make($this->validateRequest());
        // $this->authorize('update', $proiecte);
        $produse->save();

        return redirect('/produse')->with('status', 'Produsul "'.$produse->nume.'" a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Produs  $produs
     * @return \Illuminate\Http\Response
     */
    public function show(Produs $produs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Produs  $produs
     * @return \Illuminate\Http\Response
     */
    public function edit(Produs $produse)
    {
        return view('produse.edit', compact('produse'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Produs  $produs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produs $produse)
    {
        // $this->authorize('update', $proiecte);

        $produse->update($this->validateRequest());

        return redirect('/produse')->with('status', 'Produsul "'.$produse->nume.'" a fost modificat cu succes!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Produs  $produs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produs $produse)
    {
        // $this->authorize('delete', $produse);
        // dd($produse);
        $produse->delete();
        return redirect('/produse')->with('status', 'Produsul "' . $produse->nume . '" a fost șters cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest()
    {
        // dd ($request->_method);
        return request()->validate([
            'nume' =>['nullable', 'max:250'],
            'pret' => [ 'nullable', 'regex:/^(\d+(.\d{1,2})?)?$/', 'max:9999999'],
            'cantitate' => [ 'nullable', 'numeric', 'max:9999999999'],
            'cod_de_bare' => ['nullable', 'max:240'],
            'localizare' => ['nullable', 'max:250'],
            'descriere' => ['nullable', 'max:250'],
        ],
        [            
            'pret.regex' => 'Câmpul Preț nu este completat corect.',
        ]
        );
    }

    /**
     * Vanzare de produse. Scaderea cantitatii produsului
     *
     * @param  \App\Produs  $produs
     * @return \Illuminate\Http\Response
     */
    public function vanzari(Request $request)
    {         
        return view ('produse/vanzari');
    }

    public function vanzariDescarcaProdus(Request $request)
    { 
        if (isset($request->cod_de_bare)){
            $produs = Produs::where('cod_de_bare', $request->cod_de_bare)->first();

            if (isset($produs->id)){
                if (!is_numeric($request->nr_de_bucati) || $request->nr_de_bucati < 1 || $request->nr_de_bucati != round($request->nr_de_bucati)) {
                    return redirect ('produse/vanzari')->with('error', 'Numărul de bucăți nu este o valoare întreagă pozitivă: "' . $request->nr_de_bucati . '"!');
                }
                if (($produs->cantitate - $request->nr_de_bucati) < 0){
                    return redirect ('produse/vanzari')->with('error', 'Sunt mai puțin de "' . $request->nr_de_bucati . '" produse pe stoc!');
                }
                $produs->cantitate = $produs->cantitate - $request->nr_de_bucati;
                $produs->update();

                if ($request->session()->has('produse_vandute')) { 
                    $request->session()->push('produse_vandute', '' . $request->nr_de_bucati . ' buc. ' . $produs->nume); 

                } else {
                    $request->session()->put('produse_vandute', []);
                    $request->session()->push('produse_vandute', '' . $request->nr_de_bucati . ' buc. ' . $produs->nume);
                }                

                return redirect ('produse/vanzari')->with('success', 'A fost vândut ' . $request->nr_de_bucati . ' buc. "' . $produs->nume . '"!');
            } else{
                return redirect ('produse/vanzari')->with('error', 'Nu se află nici un produs in baza de date, care să aibă codul: "' . $request->cod_de_bare . '"!');
            }
        } else {
            return redirect ('produse/vanzari')->with('warning', 'Introdu un cod de bare!');
        } 
        
        return view ('produse/vanzari');
    }

    public function vanzariGolesteCos(Request $request)
    {         
        $request->session()->forget('produse_vandute');
        return view ('produse/vanzari');
    }
}
