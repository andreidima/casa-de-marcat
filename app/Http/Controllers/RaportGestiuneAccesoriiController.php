<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RaportGestiuneAccesoriiController extends Controller
{
    public function export()
    {
        $search_data = \Request::get('search_data'); //<-- we use global request to get the param of URI

        $search_data = $search_data ?? \Carbon\Carbon::today();

        return view('raport-gestiune-accesorii.export', compact('search_data'));
    }

    public function pdfExport(Request $request)
    {
        $search_data = \Request::get('search_data') ?? \Carbon\Carbon::tomorrow();

        // Accesorii
        $niruri_accesorii = \App\Nir::where('categorie_id', 3)
            ->whereDate('created_at', $search_data)
            ->oldest()
            ->get();

        // $niruri_accesorii = $niruri_accesorii->groupBy('nir');

        // Accesorii
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
            ->where('categorii_produse.id', 3) //doar pentru categoria accesorii
            ->whereDate('produse_vandute.created_at', '=', $search_data)
            ->get();

        $produse_vandute_suma = $produse_vandute->sum('total_la_raft');

        $suma_gestiune_accesorii = \App\Produs::
            whereHas('subcategorie', function ($query) {
                $query->where('categorie_produs_id', 3);
            })
            ->sum(DB::raw('cantitate * pret'));

        if ($request->view_type === 'raport-html') {
            return view(
                'raport-gestiune-accesorii.export.raport-gestiune-accesorii-pdf',
                compact('niruri_accesorii', 'produse_vandute_suma', 'suma_gestiune_accesorii', 'search_data')
            );
        } elseif ($request->view_type === 'raport-pdf') {
            $pdf = \PDF::loadView(
                'raport-gestiune-accesorii.export.raport-gestiune-accesorii-pdf',
                compact('niruri_accesorii', 'produse_vandute_suma', 'suma_gestiune_accesorii', 'search_data')
            )
                ->setPaper('a4', 'portrait');
            return $pdf->download('Raport gestiune accesorii ' .
                \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') . '.pdf');
        }
    }
}
