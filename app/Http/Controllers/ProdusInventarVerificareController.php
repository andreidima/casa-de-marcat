<?php

namespace App\Http\Controllers;

use App\ProdusInventarVerificare;
use App\Produs;
use DB;
use Illuminate\Http\Request;

class ProdusInventarVerificareController extends Controller
{
    /**
     * Display a listing of the resource.p
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume');
        $search_cod_de_bare = \Request::get('search_cod_de_bare'); //<-- we use global request to get the param of URI 
        $produse_inventar = ProdusInventarVerificare::with('produs')
            ->whereHas('produs', function ($query) use ($search_nume) {
                $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            ->whereHas('produs', function ($query) use ($search_cod_de_bare) {
                $query->where('cod_de_bare', 'like', '%' . $search_cod_de_bare . '%');
            })
            ->latest()
            ->simplePaginate(25);

        return view(
            'produse-inventar-verificare.index',
            compact('produse_inventar', 'search_nume', 'search_cod_de_bare')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('produse-inventar-verificare.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'nr_de_bucati' => ['required', 'numeric', 'between:0,99999999'],
                'cod_de_bare' => ['required', 'max:20', 'exists:produse,cod_de_bare']
            ],
            [
                'cod_de_bare.exists' => 'Codul de bare „' . $request->cod_de_bare . '” nu exista in baza de date',
            ]
        );        

        $cod_de_bare = $request->cod_de_bare;
        $produs_inventar_verificare = ProdusInventarVerificare::with('produs')
            ->whereHas('produs', function ($query) use ($cod_de_bare) {
                $query->where('cod_de_bare', $cod_de_bare);
            })
            ->first();

        if (isset($produs_inventar_verificare->id)) {
            $produs_inventar_verificare->cantitate = $produs_inventar_verificare->cantitate + $validatedData['nr_de_bucati'];
        } else {
            // dd($produs);
            $produs = Produs::where('cod_de_bare', $request->cod_de_bare)->first();
            // dd($produs);
            $produs_inventar_verificare = new ProdusInventarVerificare();
            $produs_inventar_verificare->produs_id = $produs->id;
            $produs_inventar_verificare->cantitate = $validatedData['nr_de_bucati'];
        }

        $request->session()->has('produse_inventar_verificare') ?? $request->session()->put('produse_inventar_verificare', []);
        $request->session()->push('produse_inventar_verificare', $produs_inventar_verificare->produs->nume . ' - ' . $validatedData['nr_de_bucati'] . ' buc.');
        
        $produs_inventar_verificare->save();

        return back()->with('success', 'Produsul „' . $produs_inventar_verificare->produs->nume . '” a fost adaugat în Lista de inventar cu ' . $validatedData['nr_de_bucati'] . ' bucați!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProdusInventarVerificare  $produsInventarVerificare
     * @return \Illuminate\Http\Response
     */
    public function show(ProdusInventarVerificare $produsInventarVerificare)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProdusInventarVerificare  $produsInventarVerificare
     * @return \Illuminate\Http\Response
     */
    public function edit(ProdusInventarVerificare $produse_inventar_verificare)
    {
        return view('produse-inventar-verificare.edit', compact('produse_inventar_verificare'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProdusInventarVerificare  $produsInventarVerificare
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProdusInventarVerificare $produse_inventar_verificare)
    {
        $produse_inventar_verificare->update(request()->validate(['cantitate' => ['required', 'numeric', 'between:0,99999999']]));
        return redirect('produse-inventar-verificare')->with('status', 'Produsul "' . $produse_inventar_verificare->produs->nume . '" a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProdusInventarVerificare  $produsInventarVerificare
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProdusInventarVerificare $produse_inventar_verificare)
    {
        // $this->authorize('delete', $produse);
        $produse_inventar_verificare->delete();
        return back()->with('status', 'Produsul "' . $produse_inventar_verificare->produs->nume . '" a fost șters cu succes!');
    }

    public function golesteLista(Request $request)
    {
        $request->session()->forget('produse_inventar_verificare');
        // return view('suplimenteaza-stocuri.create');
        return back();
    }

    public function produseLipsa(Request $request)
    {
        $search_nume = \Request::get('search_nume');
        $search_cod_de_bare = \Request::get('search_cod_de_bare');

        // $produse_lipsa = Produs::with('produs_inventar_verificare')
        //     ->doesntHave('produs_inventar_verificare')
        //     ->latest()
        //     ->simplePaginate(25);


        $produse_lipsa = DB::table('produse')
            ->leftJoin('produse_inventar_verificare', 'produse_inventar_verificare.produs_id', '=', 'produse.id')
            ->select(DB::raw('
                            produse_inventar_verificare.id as produs_inventar_verificare_id,
                            produse.id as produs_id,
                            produse.nume,
                            produse.cod_de_bare,
                            produse.cantitate as produs_cantitate,
                            produse_inventar_verificare.cantitate as produs_inventar_verificare_cantitate
                        '))
            ->where('produse.cantitate', '!=', 0)
            ->whereRaw('(produse_inventar_verificare.cantitate is null or produse.cantitate != produse_inventar_verificare.cantitate)')
            ->where('produse.nume', 'like', '%' . $search_nume . '%')
            ->where('produse.cod_de_bare', $search_cod_de_bare)
            ->orderBy('produse.nume')
            ->simplePaginate(25);

            // dd($produse_lipsa);

        return view(
            'produse-inventar-verificare.produse-lipsa',
            compact('produse_lipsa', 'search_nume', 'search_cod_de_bare')
        );
    }
}
