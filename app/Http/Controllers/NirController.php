<?php

namespace App\Http\Controllers;

use App\Nir;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class NirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nir = \Request::get('search_nir'); //<-- we use global request to get the param of URI

        $niruri = Nir::latest()->orderBy('nir', 'desc')->simplePaginate(25);

        return view('niruri.index', compact('niruri', 'search_nir'));
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
     * @param  \App\Nir  $nir
     * @return \Illuminate\Http\Response
     */
    public function show(Nir $nir)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Nir  $nir
     * @return \Illuminate\Http\Response
     */
    public function edit(Nir $nir)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Nir  $nir
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nir $nir)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Nir  $nir
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nir $nir)
    {
        //
    }    

    public function produse()
    {
        dd('aici');   
    }
    /**
     * Pagina principala Nir.
     *
     * @return \Illuminate\Http\Response
     */
    public function produseStocuriFaraNir()
    {        
        // $search_data = \Request::get('search_data'); //<-- we use global request to get the param of URI
        // $search_nume = \Request::get('search_nume');      
        
        // $search_data = $search_data ?? \Carbon\Carbon::today();

        // $produse_intrate = DB::table('produse_cantitati_istoric')
        //     ->leftJoin('produse', 'produse_cantitati_istoric.produs_id', '=', 'produse.id')
        //     // ->leftJoin('subcategorii_produse', 'produse.subcategorie_produs_id', '=', 'subcategorii_produse.id')
        //     // ->leftJoin('categorii_produse', 'subcategorii_produse.categorie_produs_id', '=', 'categorii_produse.id')
        //     ->select(DB::raw('
        //                     produse_cantitati_istoric.id as produse_cantitati_istoric_id,
        //                     ifnull(produse_cantitati_istoric.cantitate_initiala, 0) as cantitate_initiala,
        //                     produse_cantitati_istoric.cantitate as cantitate,
        //                     produse_cantitati_istoric.operatiune,
        //                     produse_cantitati_istoric.created_at,
        //                     produse.id as produs_id,
        //                     produse.nume,
        //                     produse.pret_de_achizitie,
        //                     produse.pret,
        //                     round(
        //                             (produse_cantitati_istoric.cantitate - ifnull(produse_cantitati_istoric.cantitate_initiala, 0)) * 
        //                             (produse.pret_de_achizitie / 1.19) 
        //                         , 2) as total_suma_achizitie,
        //                     round(
        //                             (produse_cantitati_istoric.cantitate - ifnull(produse_cantitati_istoric.cantitate_initiala, 0)) * 
        //                             (produse.pret_de_achizitie * 0.19)
        //                         , 2) as total_suma_tva,
        //                     round(
        //                             (produse_cantitati_istoric.cantitate - ifnull(produse_cantitati_istoric.cantitate_initiala, 0)) * 
        //                             produse.pret
        //                         , 2) as total_suma_vanzare
        //             '))
        //     ->whereDate('produse_cantitati_istoric.created_at', $search_data)
        //     ->when($search_nume, function ($query, $search_nume) {
        //             return $query->where('nume', 'like', '%' . str_replace(' ', '%', $search_nume) . '%');
        //         })
        //     ->where(function ($query) {
        //         $query->where('produse_cantitati_istoric.operatiune', 'adaugare')
        //               ->orWhere('produse_cantitati_istoric.operatiune', 'modificare')
        //               ->orWhere('produse_cantitati_istoric.operatiune', 'suplimentare stoc');
        //     })
        //     ->orderBy('nume')
        //     ->get();

        $produse_stocuri_telefoane_noi = \App\ProdusStoc::
            whereDoesntHave('nir')
            ->whereHas('produs', function (Builder $query) {
                $query->whereHas('subcategorie', function (Builder $query){
                    $query->where('categorie_produs_id', 1);
                });
            })
            ->oldest()
            ->get();

        $produse_stocuri_accesorii = \App\ProdusStoc::
            whereDoesntHave('nir')
            ->whereHas('produs', function (Builder $query) {
                $query->whereHas('subcategorie', function (Builder $query){
                    $query->where('categorie_produs_id', 3);
                });
            })
            ->oldest()
            ->get();

        return view('niruri.produse-stocuri-fara-nir', compact('produse_stocuri_accesorii', 'produse_stocuri_telefoane_noi'));
    }

    public function genereazaNir(Request $request)
    {
        // Telefoane noi
        $produse_stocuri_telefoane_noi = \App\ProdusStoc::
            whereDoesntHave('nir')
            ->whereHas('produs', function (Builder $query) {
                $query->whereHas('subcategorie', function (Builder $query){
                    $query->where('categorie_produs_id', 1);
                });
            })
            ->oldest()
            ->get();

        foreach($produse_stocuri_telefoane_noi->groupBy(function ($data) {
                    return \Carbon\Carbon::parse($data->created_at)->format('Y-m-d');
                }) as $produse_per_data){
            foreach($produse_per_data->groupBy('furnizor_id') as $produse_per_furnizor){
                foreach ($produse_per_furnizor->groupBy('nr_factura') as $produse_per_factura){
                    $urmatorul_nir = Nir::where('categorie_id', 1)->max('nir')+1 ?? 1;
                    foreach ($produse_per_factura as $produs_stoc){
                        $nir = Nir::make();
                        $nir->nir = $urmatorul_nir;
                        $nir->categorie_id = 1;
                        $nir->produs_stoc_id = $produs_stoc->id;
                        $nir->created_at = $nir->updated_at = \Carbon\Carbon::parse($produs_stoc->created_at)->isoFormat('YYYY-MM-DD');
                        // $nir->updated_at = $produs_stoc->updated_at;
                        $nir->save();
                    }                
                }
            }
        }

        // Accesorii
        $produse_stocuri_accesorii = \App\ProdusStoc::
            whereDoesntHave('nir')
            ->whereHas('produs', function (Builder $query) {
                $query->whereHas('subcategorie', function (Builder $query){
                    $query->where('categorie_produs_id', 3);
                });
            })
            ->oldest()
            ->get();            

        foreach($produse_stocuri_accesorii->groupBy(function ($data) {
                    return \Carbon\Carbon::parse($data->created_at)->format('Y-m-d');
                }) as $produse_per_data){
            foreach($produse_per_data->groupBy('furnizor_id') as $produse_per_furnizor){
                foreach ($produse_per_furnizor->groupBy('nr_factura') as $produse_per_factura){
                    $urmatorul_nir = Nir::where('categorie_id', 3)->max('nir')+1 ?? 1;
                    foreach ($produse_per_factura as $produs_stoc){
                        $nir = Nir::make();
                        $nir->nir = $urmatorul_nir;
                        $nir->categorie_id = 3;
                        $nir->produs_stoc_id = $produs_stoc->id;
                        $nir->created_at = $nir->updated_at = \Carbon\Carbon::parse($produs_stoc->created_at)->isoFormat('YYYY-MM-DD');
                        $nir->save();
                    }                
                }
            }
        }

        return back()->with('status', 'Nirurile au fost generate!');
        
    }

    public function pdfExport(Request $request, $search_data)
    {
        $search_data = $search_data ?? \Carbon\Carbon::today();

        // $produse_intrate = DB::table('produse_cantitati_istoric')
        //     ->leftJoin('produse', 'produse_cantitati_istoric.produs_id', '=', 'produse.id')
        //     // ->leftJoin('subcategorii_produse', 'produse.subcategorie_produs_id', '=', 'subcategorii_produse.id')
        //     // ->leftJoin('categorii_produse', 'subcategorii_produse.categorie_produs_id', '=', 'categorii_produse.id')
        //     ->select(DB::raw('
        //                 produse_cantitati_istoric.id as produse_cantitati_istoric_id,
        //                 ifnull(produse_cantitati_istoric.cantitate_initiala, 0) as cantitate_initiala,
        //                 produse_cantitati_istoric.cantitate as cantitate,
        //                 produse_cantitati_istoric.operatiune,
        //                 produse_cantitati_istoric.created_at,
        //                 produse.id as produs_id,
        //                 produse.nume,
        //                 produse.pret_de_achizitie,
        //                 produse.pret,
        //                 round(
        //                         (produse_cantitati_istoric.cantitate - ifnull(produse_cantitati_istoric.cantitate_initiala, 0)) * 
        //                         (produse.pret_de_achizitie / 1.19) 
        //                     , 2) as total_suma_achizitie,
        //                 round(
        //                         (produse_cantitati_istoric.cantitate - ifnull(produse_cantitati_istoric.cantitate_initiala, 0)) * 
        //                         (produse.pret_de_achizitie * 0.19)
        //                     , 2) as total_suma_tva,
        //                 round(
        //                         (produse_cantitati_istoric.cantitate - ifnull(produse_cantitati_istoric.cantitate_initiala, 0)) * 
        //                         produse.pret
        //                     , 2) as total_suma_vanzare
        //         '))
        //     ->whereDate('produse_cantitati_istoric.created_at', $search_data)
        //     ->where(function ($query) {
        //         $query->where('produse_cantitati_istoric.operatiune', 'adaugare')
        //             ->orWhere('produse_cantitati_istoric.operatiune', 'modificare')
        //             ->orWhere('produse_cantitati_istoric.operatiune', 'suplimentare stoc');
        //     })
        //     ->orderBy('nume')
        //     ->get();

        
        $produse_stocuri_telefoane_noi = \App\ProdusStoc::
            whereHas('produs', function (Builder $query) {
                $query->whereHas('subcategorie', function (Builder $query){
                    $query->where('categorie_produs_id', 1);
                });
            })
            ->whereDate('created_at', $search_data)
            ->get();

        $produse_stocuri_accesorii = \App\ProdusStoc::
            whereHas('produs', function (Builder $query) {
                $query->whereHas('subcategorie', function (Builder $query){
                    $query->where('categorie_produs_id', 3);
                });
            })
            ->whereDate('created_at', $search_data)
            ->get();

        if ($request->view_type === 'raport-html') {
            return view(
                'niruri.export.nir-pdf',
                compact('produse_stocuri_accesorii', 'produse_stocuri_telefoane_noi', 'search_data')
            );
        } elseif ($request->view_type === 'raport-pdf') {
            $pdf = \PDF::loadView(
                'niruri.export.nir-pdf',
                compact('produse_stocuri_accesorii', 'produse_stocuri_telefoane_noi', 'search_data')
            )
                ->setPaper('a4', 'landscape');
            return $pdf->stream('Nir ' .
                \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') . '.pdf');
        }
    }
}
