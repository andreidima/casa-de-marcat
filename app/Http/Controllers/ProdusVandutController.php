<?php

namespace App\Http\Controllers;

use App\ProdusVandut;
use App\CategoriiProduse;
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
        $search_data_inceput = \Request::get('search_data_inceput');
        $search_data_sfarsit = \Request::get('search_data_sfarsit');
        $produse_vandute = ProdusVandut::with('produs')
            ->whereHas('produs', function ($query) use ($search_cod_de_bare) {
                $query->where('cod_de_bare', 'like', '%' . $search_cod_de_bare . '%');
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
            compact('produse_vandute', 'search_cod_de_bare', 'search_data_inceput', 'search_data_sfarsit'));
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
    public function destroy(ProdusVandut $produsVandut)
    {
        //
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
            $produse_vandute_suma_totala_raft = ProdusVandut::join('produse', 'produse_vandute.produs_id', '=', 'produse.id')
                ->when($search_data, function ($query, $search_data) {
                return $query->whereDate('produse_vandute.created_at', $search_data);
                })
                ->sum(DB::raw('produse_vandute.cantitate * produse.pret'));
            // dd($search_data, $produse_vandute_suma_totala_raft);
        } else {
            return view('produse-vandute.rapoarte.raport-zilnic', compact('produse_vandute', 'search_data'));
        }

        if ($request->view_type === 'raport-html') {
            return view('produse-vandute.rapoarte.export.raport-zilnic-pdf', compact('produse_vandute', 'produse_vandute_nr', 'produse_vandute_suma_totala', 'produse_vandute_suma_totala_raft', 'search_data'));
        } elseif ($request->view_type === 'raport-pdf') {
            // $pdf->render();

            $pdf = \PDF::loadView('produse-vandute.rapoarte.export.raport-zilnic-pdf', compact('produse_vandute', 'produse_vandute_nr', 'produse_vandute_suma_totala', 'produse_vandute_suma_totala_raft', 'search_data'))
                ->setPaper('a4');
            return $pdf->download('Raport produse vandute ' . \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') . '.pdf');
        }

    }
}
