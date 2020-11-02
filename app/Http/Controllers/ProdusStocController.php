<?php

namespace App\Http\Controllers;

use App\ProdusStoc;
use Illuminate\Http\Request;

class ProdusStocController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_produs_nume = \Request::get('search_produs_nume'); //<-- we use global request to get the param of URI  
        $stocuri = ProdusStoc::
            // when($search_produs_nume, function ($query, $search_produs_nume) {
            //     return $query->where('nume', 'like', '%' . str_replace(' ', '%', $search_produs_nume) . '%');
            // })
            // with(['produs' => function ($query) use ($search_produs_nume) {
            //     $query->when($search_produs_nume, function ($query, $search_produs_nume) {
            //         return $query->where('nume', 'like', '%' . str_replace(' ', '%', $search_produs_nume) . '%');
            //     });
            // }])
            with('produs', 'furnizor')
            ->whereHas('produs', function ($query) use ($search_produs_nume) { 
                $query->when($search_produs_nume, function ($query, $search_produs_nume) {
                    return $query->where('nume', 'like', '%' . str_replace(' ', '%', $search_produs_nume) . '%');
                });
            })
            // ->where('produs.nume', 'asd')
            ->latest()
            ->simplePaginate(25);
        // dd($stocuri);

        return view('produse-stocuri.index', compact('stocuri', 'search_produs_nume'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('produse-stocuri.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProdusStoc  $produsStoc
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ProdusStoc $produse_stocuri)
    {
        return view('produse-stocuri.show', compact('produse_stocuri'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProdusStoc  $produsStoc
     * @return \Illuminate\Http\Response
     */
    public function edit(ProdusStoc $produse_stocuri)
    {
        $furnizori = \App\Furnizor::select('id', 'nume')->get();

        return view('produse-stocuri.edit', compact('produse_stocuri', 'furnizori'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProdusStoc  $produsStoc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProdusStoc $produse_stocuri)
    {
        $validatedData = $request->validate([
            // 'produs_id' => ['nullable', 'exists:produse,id'],
            'furnizor_id' => ['nullable', 'exists:furnizori,id'],
            'nr_factura' => ['nullable', 'max:190'],
            'pret_de_achizitie' => ['nullable', 'numeric', 'between:0.01,99999.99'],
            'cantitate' => ['required', 'numeric', 'between:-999999,999999'],
            'cod_de_bare' => ['required', 'max:20', 'exists:produse,cod_de_bare'],
            'fara_nir' => ['required']
            ],
        [            
            'cod_de_bare.exists' => 'Codul de bare „' . $request->cod_de_bare . '” nu exista in baza de date',
        ]);

        // Cautare produs
        $produs = \App\Produs::where('cod_de_bare', $request->cod_de_bare)->first();
        
        // Daca produsul a fost gasit, se face actualizarea tuturor tabelelor
        if (isset($produs->id)) {
            // dd($produse_stocuri->produs->id, $produs->id);
        
            // Verificare daca a fost schimbat produsul
            if ($produse_stocuri->produs->id === $produs->id){ // produsul este acelasi

                    if ($produs->cod_de_bare !== "G11005") { // se sare peste produsul „INCARCARE 1 EURO”, caruia i se permite stoc negativ
                        if (($produs->cantitate - $produse_stocuri->cantitate + $request->cantitate) < 0){
                            return back()->with('error', 'Această modificare va scade cantitatea totala a produsului „' . $produs->nume . '” sub 0, ceea ce este incorect!');
                        }
                    }

                    // Crearea "ProdusCantitateIstoric" si salvarea cantitatii initiale
                    $produse_cantitati_istoric = \App\ProdusCantitateIstoric::make();
                    $produse_cantitati_istoric->cantitate_initiala = $produs->cantitate;

                    // Actualizarea cantitatii produsului din tabela "Produs"
                    $produs->cantitate = $produs->cantitate - $produse_stocuri->cantitate + $request->cantitate;
                    $produs->update();

                    // Actualizarea cantitatii produsului din tabela "ProdusIstoric"
                    $produse_istoric = \App\ProdusIstoric::make($produs->toArray());
                    unset($produse_istoric['id'], $produse_istoric['created_at'], $produse_istoric['updated_at']);
                    $produse_istoric->produs_id = $produs->id;
                    // $produse_istoric->furnizor_id = $furnizor_id;
                    $produse_istoric->user = auth()->user()->id;
                    $produse_istoric->operatiune = 'modificare stoc';
                    $produse_istoric->save();
                    
                    // Actualizarea cantitatii produsului din tabela "ProdusCantitateIstoric"
                    $produse_cantitati_istoric->produs_id = $produs->id;
                    $produse_cantitati_istoric->cantitate = $produs->cantitate;
                    $produse_cantitati_istoric->operatiune = 'modificare stoc';
                    $produse_cantitati_istoric->save();
                    
                    // Actualizarea cantitatii produsului din tabela "ProdusStoc"
                    $produse_stocuri->produs_id = $produs->id;
                    $produse_stocuri->furnizor_id = $request->furnizor_id;
                    $produse_stocuri->nr_factura = $request->nr_factura;
                    $produse_stocuri->pret_de_achizitie = $request->pret_de_achizitie;
                    $produse_stocuri->cantitate = $request->cantitate;
                    $produse_stocuri->fara_nir = $request->fara_nir;
                    $produse_stocuri->update();
                
            } else { // produsul este altul

                // Stergere produs vechi
                    // Cautare produs
                    $produs = \App\Produs::where('id', $produse_stocuri->produs_id)->first();

                    // Salvare data pentru a o adauga la produsul nou
                    $created_at = $produs->created_at;

                    // Verificare initiala pentru a nu scadea cantitatea sub 0
                    if ($produs->cod_de_bare !== "G11005") { // se sare peste produsul „INCARCARE 1 EURO”, caruia i se permite stoc negativ
                        if (($produs->cantitate - $produse_stocuri->cantitate) < 0){
                            return back()->with('error', 'Această modificare va scade cantitatea produsului „' . $produs->nume . '” sub 0, ceea ce este incorect!');
                        }
                    }

                    // Crearea "ProdusCantitateIstoric" si salvarea cantitatii initiale
                    $produse_cantitati_istoric = \App\ProdusCantitateIstoric::make();
                    $produse_cantitati_istoric->cantitate_initiala = $produs->cantitate;

                    // Actualizarea cantitatii produsului din tabela "Produs"
                    $produs->cantitate = $produs->cantitate - $produse_stocuri->cantitate;
                    $produs->update();

                    // Actualizarea cantitatii produsului din tabela "ProdusIstoric"
                    $produse_istoric = \App\ProdusIstoric::make($produs->toArray());
                    unset($produse_istoric['id'], $produse_istoric['created_at'], $produse_istoric['updated_at']);
                    $produse_istoric->produs_id = $produs->id;
                    $produse_istoric->user = auth()->user()->id;
                    $produse_istoric->operatiune = 'stergere stoc';
                    $produse_istoric->save();
                
                    // Actualizarea cantitatii produsului din tabela "ProdusCantitateIstoric"
                    $produse_cantitati_istoric->produs_id = $produs->id;
                    $produse_cantitati_istoric->cantitate = $produs->cantitate;
                    $produse_cantitati_istoric->operatiune = 'stergere stoc';
                    $produse_cantitati_istoric->save();

                    // Stergerea cantitatii produsului din tabela "ProdusStoc"
                    $produse_stocuri->delete();

                // Adaugarea stocului la un alt produs
                    // Cautare produs
                    $produs = \App\Produs::where('cod_de_bare', $request->cod_de_bare)->first();

                    // Crearea "ProdusCantitateIstoric" si salvarea cantitatii initiale
                    $produse_cantitati_istoric = \App\ProdusCantitateIstoric::make();
                    $produse_cantitati_istoric->cantitate_initiala = $produs->cantitate;

                    // Actualizarea cantitatii produsului din tabela "Produs"
                    $produs->cantitate = $produs->cantitate + $request->cantitate;
                    $produs->update();

                    // Actualizarea cantitatii produsului din tabela "ProdusIstoric"
                    $produse_istoric = \App\ProdusIstoric::make($produs->toArray());
                    unset($produse_istoric['id'], $produse_istoric['created_at'], $produse_istoric['updated_at']);
                    $produse_istoric->produs_id = $produs->id;
                    // $produse_istoric->furnizor_id = $furnizor_id;
                    $produse_istoric->user = auth()->user()->id;
                    $produse_istoric->operatiune = 'suplimentare stoc';
                    // $produse_istoric->created_at = $created_at;
                    $produse_istoric->save();
                    
                    // Actualizarea cantitatii produsului din tabela "ProdusCantitateIstoric"
                    $produse_cantitati_istoric->produs_id = $produs->id;
                    $produse_cantitati_istoric->cantitate = $produs->cantitate;
                    $produse_cantitati_istoric->operatiune = 'suplimentare stoc';
                    // $produse_cantitati_istoric->created_at = $created_at;
                    $produse_cantitati_istoric->save();
                    
                    // Inserarea cantitatii produsului in tabela "ProdusStoc"
                    $produse_stocuri->produs_id = $produs->id;
                    $produse_stocuri->furnizor_id = $request->furnizor_id;
                    $produse_stocuri->nr_factura = $request->nr_factura;
                    $produse_stocuri->pret_de_achizitie = $request->pret_de_achizitie;
                    $produse_stocuri->cantitate = $request->cantitate;
                    $produse_stocuri->fara_nir = $request->fara_nir;
                    $produse_stocuri->created_at = $created_at;
                    $produse_stocuri->save(); 
            }
        }

            // return redirect('suplimenteaza-stocuri/adauga/' . $furnizor_id)->with('success', 'Produsul „' . $produs->nume . '” a fost suplimentat cu ' . $validatedData['nr_de_bucati'] . ' bucați!');
            // return redirect ('suplimenteaza-stocuri/adauga' . $furnizor_id)->with('error', 'Nu se află nici un produs in baza de date, care să aibă codul: "' . $request->cod_de_bare . '"!');

        return redirect('/produse-stocuri')->with('status', 'Înregistrarea a fost modificată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProdusStoc  $produsStoc
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProdusStoc $produse_stocuri)
    {
        // Cautare produs
        $produs = \App\Produs::where('id', $produse_stocuri->produs_id)->first();

        // Verificare initiala pentru a nu scadea cantitatea sub 0
        if ($produs->cod_de_bare !== "G11005") { // se sare peste produsul „INCARCARE 1 EURO”, caruia i se permite stoc negativ
            if (($produs->cantitate - $produse_stocuri->cantitate) < 0) {
                return back()->with('error', 'Această modificare va scade cantitatea produsului „' . $produs->nume . '” sub 0, ceea ce este incorect!');
            }
        }

        // Crearea "ProdusCantitateIstoric" si salvarea cantitatii initiale
        $produse_cantitati_istoric = \App\ProdusCantitateIstoric::make();
        $produse_cantitati_istoric->cantitate_initiala = $produs->cantitate;

        // Actualizarea cantitatii produsului din tabela "Produs"
        $produs->cantitate = $produs->cantitate - $produse_stocuri->cantitate;
        $produs->update();

        // Actualizarea cantitatii produsului din tabela "ProdusIstoric"
        $produse_istoric = \App\ProdusIstoric::make($produs->toArray());
        unset($produse_istoric['id'], $produse_istoric['created_at'], $produse_istoric['updated_at']);
        $produse_istoric->produs_id = $produs->id;
        $produse_istoric->user = auth()->user()->id;
        $produse_istoric->operatiune = 'stergere stoc';
        $produse_istoric->save();

        // Actualizarea cantitatii produsului din tabela "ProdusCantitateIstoric"
        $produse_cantitati_istoric->produs_id = $produs->id;
        $produse_cantitati_istoric->cantitate = $produs->cantitate;
        $produse_cantitati_istoric->operatiune = 'stergere stoc';
        $produse_cantitati_istoric->save();

        // Stergerea cantitatii produsului din tabela "ProdusStoc"
        $produse_stocuri->delete();

        return redirect('/produse-stocuri')->with('status', 'Stocul a fost șters cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest()
    {
        return request()->validate([
            'produs_id' => ['nullable', 'exists:produse,id'],
            'furnizor_id' => ['nullable', 'exists:furnizori,id'],
            'nr_factura' => ['nullable', 'max:190'],
            'cantitate' => ['required', 'numeric', 'between:-999999,999999'],
            'cod_de_bare' => ['required', 'max:20', 'exists:produse,cod_de_bare']
        ]
        );
    }
}
