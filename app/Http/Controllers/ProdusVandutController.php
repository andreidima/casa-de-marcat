<?php

namespace App\Http\Controllers;

use App\Produs;
use App\ProdusIstoric;
use App\ProdusCantitateIstoric;
use App\ProdusVandut;
use App\CategoriiProduse;
use App\Avans;
use App\Plata;
use App\Casa;
use DB;
use Illuminate\Http\Request;

class ProdusVandutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_cod_de_bare = \Request::get('search_cod_de_bare'); //<-- we use global request to get the param of URI   
        $search_detalii = \Request::get('search_detalii');     
        $search_data_inceput = \Request::get('search_data_inceput');
        $search_data_sfarsit = \Request::get('search_data_sfarsit');
        $produse_vandute = ProdusVandut::with('produs')
            ->whereHas('produs', function ($query) use ($search_cod_de_bare) {
                $query->where('cod_de_bare', 'like', '%' . $search_cod_de_bare . '%');
            })
            ->when($search_detalii, function ($query, $search_detalii) {
                    return $query->where('detalii', 'like', '%' . str_replace(' ', '%', $search_detalii) . '%');
                })
            ->when($search_data_inceput, function ($query, $search_data_inceput) {
                return $query->whereDate('created_at', '>=', $search_data_inceput);
            })
            ->when($search_data_sfarsit, function ($query, $search_data_sfarsit) {
                // return $query->whereDate('created_at', '<=', \Carbon\Carbon::parse($search_data_sfarsit)->addDay());
                return $query->whereDate('created_at', '<=', $search_data_sfarsit);
            })
            // ->oldest()
            ->latest()
            ->simplePaginate(25);

        return view('produse-vandute.index', 
            compact('produse_vandute', 'search_cod_de_bare', 'search_data_inceput', 'search_data_sfarsit', 'search_detalii'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\ProdusVandut  $produsVandut
     * @return \Illuminate\Http\Response
     */
    public function show(ProdusVandut $produsVandut)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProdusVandut  $produsVandut
     * @return \Illuminate\Http\Response
     */
    public function edit(ProdusVandut $produsVandut)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProdusVandut  $produsVandut
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProdusVandut $produsVandut)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProdusVandut  $produsVandut
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProdusVandut $produse_vandute)
    {
        // $this->authorize('delete', $produse);
        
        $produs = Produs::where('id', $produse_vandute->produs_id)->first();

        $produse_cantitati_istoric = ProdusCantitateIstoric::make();
        $produse_cantitati_istoric->cantitate_initiala = $produs->cantitate;

        $produs->cantitate += $produse_vandute->cantitate;
        $produs->update();

        $produse_istoric = ProdusIstoric::make($produs->toArray());
        unset($produse_istoric['id'], $produse_istoric['created_at'], $produse_istoric['updated_at']);
        $produse_istoric->produs_id = $produs->id;
        $produse_istoric->user = auth()->user()->id;
        $produse_istoric->operatiune = 'vanzare stearsa';
        $produse_istoric->save();

        $produse_cantitati_istoric->produs_id = $produs->id;
        $produse_cantitati_istoric->cantitate = $produs->cantitate;
        $produse_cantitati_istoric->operatiune = 'vanzare stearsa';
        $produse_cantitati_istoric->save();
        
        // $casa = Casa::make();
        // $casa->referinta_tabel = 'produse_vandute';
        // $casa->referinta_id = $produse_vandute->id;
        // $casa->suma_initiala = Casa::latest()->first()->suma;
        // $casa->suma = $casa->suma_initiala - ($produse_vandute->cantitate * $produse_vandute->pret);
        // $casa->operatiune = 'Vânzare ștearsă';
        // $casa->save();
        
        $produse_vandute->delete();

        return redirect('/produse-vandute')
            ->with('status', 'Vânzarea produsului „' . $produse_vandute->produs->nume . ' - ' . $produse_vandute->detalii . '” a fost ștearsă cu succes! ' . 
                'Produsul a fost readăugat în gestiune!'
            );
    }

    /**
     * Extragere raport pe o zi.
     *
     * @return \Illuminate\Http\Response
     */
    public function rapoarteRaportZilnic(Request $request)
    {        
        $search_data = \Request::get('search_data'); //<-- we use global request to get the param of URI 
        
        $search_data = $search_data ?? \Carbon\Carbon::now();

        // $produse_vandute = DB::table('view_produse_vandute')
        //     ->whereDate('created_at', '=', $search_data)
        //     ->get(); 

        $produse_vandute = DB::table('produse_vandute')
            ->leftJoin('produse', 'produse_vandute.produs_id', '=', 'produse.id')
            ->leftJoin('subcategorii_produse', 'produse.subcategorie_produs_id', '=', 'subcategorii_produse.id')
            ->leftJoin('categorii_produse', 'subcategorii_produse.categorie_produs_id', '=', 'categorii_produse.id')
            ->select(DB::raw('
                            produse_vandute.id,
                            produse.nume,
                            produse_vandute.cantitate,
                            produse.pret as pret_la_raft,
                            produse_vandute.pret as pret_vandut,
                            produse_vandute.cantitate * produse.pret as total_la_raft,
                            produse_vandute.cantitate * produse_vandute.pret as total_vandut,
                            produse_vandute.card,
                            produse_vandute.emag,
                            produse_vandute.detalii,
                            subcategorii_produse.id as subcategorie_id,
                            subcategorii_produse.nume as subcategorie_nume,
                            categorii_produse.id as categorie_id,
                            categorii_produse.nume as categorie_nume,
                            produse_vandute.created_at
                    '))
            ->whereDate('produse_vandute.created_at', '=', $search_data)
            ->get();    
            // dd($produse_vandute);      
                            
        $avansuri = Avans::when($search_data, function ($query, $search_data) {
                return $query->whereDate('created_at', $search_data);
            })
            ->get();   

        $plati = Plata::when($search_data, function ($query, $search_data) {
                return $query->whereDate('created_at', $search_data);
            })
            ->get();

        $produse_vandute_nr = ProdusVandut::
            when($search_data, function ($query, $search_data) {
                return $query->whereDate('created_at', $search_data);
            })
            ->sum('cantitate');
        $produse_vandute_suma_totala = ProdusVandut::
            when($search_data, function ($query, $search_data) {
                return $query->whereDate('created_at', $search_data);
            })
            ->sum(DB::raw('cantitate * pret'));  

        return view('produse-vandute.rapoarte.raport-zilnic', compact('produse_vandute', 'produse_vandute_nr', 'produse_vandute_suma_totala', 'avansuri', 'plati', 'search_data'));
    }

    public function pdfExportRaportZilnic(Request $request, $search_data)
    {
        // $data_traseu_Ymd = \Carbon\Carbon::createFromFormat('d-m-Y', $data_traseu)->format('Y-m-d');
        // $data_raport = \Carbon\Carbon::createFromFormat('d-m-Y', $data_raport)->format('d.m.Y');

        if (isset($search_data)) {
            $produse_vandute = ProdusVandut::with('produs')
                ->when($search_data, function ($query, $search_data) {
                    return $query->whereDate('created_at', $search_data);
                })
                ->get();
            $produse_vandute_nr = ProdusVandut::when($search_data, function ($query, $search_data) {
                    return $query->whereDate('created_at', $search_data);
                })
                ->sum('cantitate');
            $produse_vandute_suma_totala = ProdusVandut::when($search_data, function ($query, $search_data) {
                    return $query->whereDate('created_at', $search_data);
                })
                ->sum(DB::raw('cantitate * pret'));
            $produse_vandute_suma_totala_fara_card_si_emag = ProdusVandut::
                when($search_data, function ($query, $search_data) {
                    return $query->whereDate('created_at', $search_data);
                })
                ->whereNull('card')
                ->whereNull('emag')
                ->sum(DB::raw('cantitate * pret'));
            $produse_vandute_suma_totala_raft = ProdusVandut::join('produse', 'produse_vandute.produs_id', '=', 'produse.id')
                ->when($search_data, function ($query, $search_data) {
                return $query->whereDate('produse_vandute.created_at', $search_data);
                })
                ->sum(DB::raw('produse_vandute.cantitate * produse.pret'));
                            
            $avansuri = Avans::when($search_data, function ($query, $search_data) {
                    return $query->whereDate('created_at', $search_data);
                })
                ->get();
            $avansuri_suma_totala = Avans::when($search_data, function ($query, $search_data) {
                    return $query->whereDate('created_at', $search_data);
                })
                ->sum('suma');
        } else {
            return view('produse-vandute.rapoarte.raport-zilnic', compact('produse_vandute', 'search_data'));
        }

        if ($request->view_type === 'raport-html') {
            return view('produse-vandute.rapoarte.export.raport-zilnic-pdf', 
                compact('produse_vandute', 'produse_vandute_nr', 'produse_vandute_suma_totala', 'produse_vandute_suma_totala_fara_card_si_emag', 
                    'produse_vandute_suma_totala_raft', 
                    'avansuri', 'avansuri_suma_totala',
                    'search_data'));
        } elseif ($request->view_type === 'raport-pdf') {
            $pdf = \PDF::loadView('produse-vandute.rapoarte.export.raport-zilnic-pdf', 
                compact('produse_vandute', 'produse_vandute_nr', 'produse_vandute_suma_totala', 'produse_vandute_suma_totala_fara_card_si_emag', 
                    'produse_vandute_suma_totala_raft', 
                    'avansuri', 'avansuri_suma_totala',
                    'search_data'))
                ->setPaper('a4');
            return $pdf->download('Raport produse vandute ' . \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') . '.pdf');
        }

    }

    public function pdfExportRaportZilnicPerCategorie(Request $request, $search_data, $categorie_id)
    {

        if (isset($search_data)) {
            // $produse_vandute = DB::table('view_produse_vandute')
            //     ->where('categorie_id', $categorie_id) 
            //     ->whereDate('created_at', '=', $search_data)
            //     ->get();

            $produse_vandute = DB::table('produse_vandute')
                ->leftJoin('produse', 'produse_vandute.produs_id', '=', 'produse.id')
                ->leftJoin('subcategorii_produse', 'produse.subcategorie_produs_id', '=', 'subcategorii_produse.id')
                ->leftJoin('categorii_produse', 'subcategorii_produse.categorie_produs_id', '=', 'categorii_produse.id')
                ->select(DB::raw('
                            produse_vandute.id,
                            produse.nume,
                            produse_vandute.cantitate,
                            produse.pret as pret_la_raft,
                            produse_vandute.pret as pret_vandut,
                            produse_vandute.cantitate * produse.pret as total_la_raft,
                            produse_vandute.cantitate * produse_vandute.pret as total_vandut,
                            produse_vandute.card,
                            produse_vandute.emag,
                            produse_vandute.detalii,
                            subcategorii_produse.id as subcategorie_id,
                            subcategorii_produse.nume as subcategorie_nume,
                            categorii_produse.id as categorie_id,
                            categorii_produse.nume as categorie_nume,
                            produse_vandute.created_at
                        '))
                ->where('categorii_produse.id', $categorie_id)
                ->whereDate('produse_vandute.created_at', '=', $search_data)
                ->get();   
        } else {
            return view('produse-vandute.rapoarte.raport-zilnic', compact('produse_vandute', 'search_data'));
        }

        if ($request->view_type === 'raport-html') {
            return view('produse-vandute.rapoarte.export.raport-zilnic-per-categorie-pdf', 
                compact('produse_vandute', 'search_data'));
        } elseif ($request->view_type === 'raport-pdf') {
            $pdf = \PDF::loadView('produse-vandute.rapoarte.export.raport-zilnic-per-categorie-pdf', 
                compact('produse_vandute', 'search_data'))
                ->setPaper('a4');
            return $pdf->download('Raport produse vandute - ' . $produse_vandute->first()->categorie_nume . ' - ' . 
                \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') . '.pdf');
        }
    }

    public function pdfExportRaportZilnicAvansuri(Request $request, $search_data)
    {
        if (isset($search_data)) {
            $avansuri = Avans::when($search_data, function ($query, $search_data) {
                return $query->whereDate('created_at', $search_data);
            })
                ->get();
        } else {
            return view('produse-vandute.rapoarte.raport-zilnic', compact('produse_vandute', 'search_data'));
        }

        if ($request->view_type === 'raport-html') {
            return view(
                'produse-vandute.rapoarte.export.raport-zilnic-avansuri-pdf',
                compact('avansuri', 'search_data')
            );
        } elseif ($request->view_type === 'raport-pdf') {
            $pdf = \PDF::loadView(
                'produse-vandute.rapoarte.export.raport-zilnic-avansuri-pdf',
                compact('avansuri', 'search_data')
            )
                ->setPaper('a4');
            return $pdf->download('Raport avansuri ' .
                \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') . '.pdf');
        }
    }

    public function pdfExportRaportZilnicPlati(Request $request, $search_data)
    {
        if (isset($search_data)) {
            $plati = Plata::when($search_data, function ($query, $search_data) {
                return $query->whereDate('created_at', $search_data);
            })
                ->get();
        } else {
            return view('produse-vandute.rapoarte.raport-zilnic', compact('produse_vandute', 'search_data'));
        }

        if ($request->view_type === 'raport-html') {
            return view(
                'produse-vandute.rapoarte.export.raport-zilnic-plati-pdf',
                compact('plati', 'search_data')
            );
        } elseif ($request->view_type === 'raport-pdf') {
            $pdf = \PDF::loadView(
                'produse-vandute.rapoarte.export.raport-zilnic-plati-pdf',
                compact('plati', 'search_data')
            )
                ->setPaper('a4');
            return $pdf->download('Raport plati ' .
                \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') . '.pdf');
        }
    }
}
