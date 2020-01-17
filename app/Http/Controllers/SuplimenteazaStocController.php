<?php

namespace App\Http\Controllers;

use App\Produs;
use App\ProdusCantitateIstoric;
use App\ProdusIstoric;

use Illuminate\Http\Request;

class SuplimenteazaStocController extends Controller
{

    /**
     * Deschide formularul pentru suplimentarea de stoc
     */
    public function create()
    {
        return view('suplimenteaza-stocuri.create');
    }

    /**
     * Salveaza suplimentarea de stoc
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nr_de_bucati' => ['required', 'numeric', 'between:0,99999999'],
            'cod_de_bare' => ['required', 'max:20', 'exists:App\Produs,cod_de_bare']
            ],
        [            
            'cod_de_bare.exists' => 'Codul de bare „' . $request->cod_de_bare . '” nu exista in baza de date',
        ]);
        
        dd($validatedData);

        // $produs = Produs::where('cod_de_bare', $request->cod_de_bare)->first();

        // dd($produs);

        // if (isset($produs->id)) {
        //     $produse_cantitati_istoric = ProdusCantitateIstoric::make();
        //     $produse_cantitati_istoric->cantitate_initiala = $produs->cantitate;

        //     $produs->cantitate = $produs->cantitate + $validatedData['nr_de_bucati'];
        //     $produs->update();

        //     $produse_istoric = ProdusIstoric::make($produs->toArray());
        //     unset($produse_istoric['id'], $produse_istoric['created_at'], $produse_istoric['updated_at']);
        //     $produse_istoric->produs_id = $produs->id;
        //     $produse_istoric->user = auth()->user()->id;
        //     $produse_istoric->operatiune = 'suplimentare stoc';
        //     $produse_istoric->save();

        //     $produse_cantitati_istoric->produs_id = $produs->id;
        //     $produse_cantitati_istoric->cantitate = $produs->cantitate;
        //     $produse_cantitati_istoric->operatiune = 'suplimentare stoc';
        //     $produse_cantitati_istoric->save();

        //     $request->session()->has('suplimentare_stocuri') ?? $request->session()->put('suplimentare_stocuri', []);

        //     $request->session()->push('suplimentare_stocuri', $produs->nume);

        //     return redirect('suplimenteaza-stocuri/adauga')->with('success', 'Produsul „' . $produs->nume . '” a fost suplimentat cu ' . $validatedData['nr_de_bucati'] . ' bucați!');
        // } else {
        //     return redirect ('suplimenteaza-stocuri/adauga')->with('error', 'Nu se află nici un produs in baza de date, care să aibă codul: "' . $request->cod_de_bare . '"!');
        // }
    }

    public function golesteLista(Request $request)
    {
        $request->session()->forget('suplimentare_stocuri');
        return view('suplimenteaza-stocuri.create');
    }
}
