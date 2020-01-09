<?php

namespace App\Http\Controllers;

use App\Produs;
use App\ProdusIstoric;
use App\ProdusVandut;
use App\CategoriiProduse;
use App\Avans;
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
        $produs->cantitate += $produse_vandute->cantitate;
        $produs->update();

        $produse_istoric = ProdusIstoric::make($produs->toArray());
        unset($produse_istoric['id'], $produse_istoric['created_at'], $produse_istoric['updated_at']);
        $produse_istoric->produs_id = $produs->id;
        $produse_istoric->user = auth()->user()->id;
        $produse_istoric->operatiune = 'vanzare';
        $produse_istoric->save();
        
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
        
        $produse_vandute = ProdusVandut::with('produs')
            ->when($search_data, function ($query, $search_data) {
                return $query->whereDate('created_at', $search_data);
            })
            ->latest()
            ->Paginate(25);
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

        return view('produse-vandute.rapoarte.raport-zilnic', compact('produse_vandute', 'produse_vandute_nr', 'produse_vandute_suma_totala', 'search_data'));
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
}
