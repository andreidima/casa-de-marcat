<?php

namespace App\Http\Controllers;

use App\Produs;
use App\ProdusCantitateIstoric;
use App\ProdusIstoric;
use App\Furnizor;
use App\ProdusStoc;

use Illuminate\Http\Request;

class SuplimenteazaStocController extends Controller
{

    /**
     * Deschide formularul pentru suplimentarea de stoc
     */
    public function create($furnizor_id = null)
    {
        $furnizori = Furnizor::select('id', 'nume')->get();
        // dd($furnizori);
        return view('suplimenteaza-stocuri.create', compact('furnizori', 'furnizor_id'));
    }

    /**
     * Salveaza suplimentarea de stoc
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'furnizor_id' => ['nullable', 'exists:furnizori,id'],
            'nr_factura' => ['nullable', 'max:190'],
            'pret_de_achizitie' => ['nullable', 'numeric', 'between:0.01,99999.99'],
            'nr_de_bucati' => ['required', 'numeric', 'between:-999999,999999'],
            'cod_de_bare' => ['required', 'max:20', 'exists:produse,cod_de_bare'],
            'fara_nir' => ['required']
            ],
        [            
            'cod_de_bare.exists' => 'Codul de bare „' . $request->cod_de_bare . '” nu exista in baza de date',
        ]);
        
        // dd($validatedData);

        $produs = Produs::where('cod_de_bare', $request->cod_de_bare)->first();
        $furnizor_id = $validatedData['furnizor_id'];

        // dd($produs);

        if (isset($produs->id)) {
            if ($produs->cod_de_bare !== "G11005"){ // se sare peste produsul „INCARCARE 1 EURO”, caruia i se permite stoc negativ
                if (($produs->cantitate + $request->nr_de_bucati) < 0) {
                    return back()->with('error', 'Această modificare va scade cantitatea totala a produsului „' . $produs->nume . '” sub 0, ceea ce este incorect!');
                }
            }

            $produse_cantitati_istoric = ProdusCantitateIstoric::make();
            $produse_cantitati_istoric->cantitate_initiala = $produs->cantitate;

            $produs->cantitate = $produs->cantitate + $validatedData['nr_de_bucati'];
            $produs->update();

            $produse_istoric = ProdusIstoric::make($produs->toArray());
            unset($produse_istoric['id'], $produse_istoric['created_at'], $produse_istoric['updated_at']);
            $produse_istoric->produs_id = $produs->id;
            // $produse_istoric->furnizor_id = $furnizor_id;
            $produse_istoric->user = auth()->user()->id;
            $produse_istoric->operatiune = 'suplimentare stoc';
            $produse_istoric->save();

            $produse_cantitati_istoric->produs_id = $produs->id;
            // $produse_cantitati_istoric->furnizor_id = $furnizor_id;
            $produse_cantitati_istoric->cantitate = $produs->cantitate;
            $produse_cantitati_istoric->operatiune = 'suplimentare stoc';
            $produse_cantitati_istoric->save();

            $produs_stoc = ProdusStoc::make();
            $produs_stoc->produs_id = $produs->id;
            $produs_stoc->furnizor_id = $validatedData['furnizor_id'];
            $produs_stoc->nr_factura = $validatedData['nr_factura'];
            $produs_stoc->pret_de_achizitie = $validatedData['pret_de_achizitie'];
            $produs_stoc->cantitate = $validatedData['nr_de_bucati'];
            $produs_stoc->fara_nir = $validatedData['fara_nir'];
            $produs_stoc->save();

            $request->session()->has('suplimentare_stocuri') ?? $request->session()->put('suplimentare_stocuri', []);

            $request->session()->push('suplimentare_stocuri', $produs->nume);

            return redirect('suplimenteaza-stocuri/adauga/' . $furnizor_id)->with('success', 'Produsul „' . $produs->nume . '” a fost suplimentat cu ' . $validatedData['nr_de_bucati'] . ' bucați!');
        } else {
            return redirect ('suplimenteaza-stocuri/adauga' . $furnizor_id)->with('error', 'Nu se află nici un produs in baza de date, care să aibă codul: "' . $request->cod_de_bare . '"!');
        }
    }

    public function golesteLista(Request $request)
    {
        $request->session()->forget('suplimentare_stocuri');
        return back();
    }
}
