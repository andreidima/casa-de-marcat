<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GenereazaFacturaClientController extends Controller
{
    public function completareDate(Request $request)
    {
        $produse_vandute = $request->session()->get('produse_vandute');

        if (isset($produse_vandute)){
            return view('genereaza-factura-client.completare-date', compact('produse_vandute'));
        } else {
            return redirect('/produse/vanzari');
        }
    }

    public function salvareDate(Request $request)
    {        
        $produse_vandute = $request->session()->get('produse_vandute');

        if (isset($produse_vandute)){
            $validatedData = $request->validate([
                'firma' => ['nullable', 'max:200'],
                'nr_reg_com' => ['nullable', 'max:200'],
                'cif_cnp' => ['nullable', 'max:200'],
                'adresa' => ['nullable', 'max:200'],
                'delegat' => ['nullable', 'max:200'],
                'seria_nr_buletin' => ['nullable', 'max:200'],
                'telefon' => ['nullable', 'max:200']
            ]);

            $factura = \App\Factura::make($validatedData);
            $factura->seria = 'VNGSM';
            $factura->numar = \App\Factura::select('numar')->max('numar') + 1;
            $factura->save();

            foreach ($produse_vandute as $produs){
                // dd($produs['nume']);
                $produs_factura = \App\FacturaProdus::make();
                $produs_factura->factura_id = $factura->id;
                $produs_factura->nume = $produs['nume'];
                $produs_factura->um = 'BUC';
                $produs_factura->cantitate = $produs['cantitate'];
                $produs_factura->pret_unitar = number_format(round_up(($produs['pret'] / $produs['cantitate'] / 1.19), 2), 2);
                $produs_factura->valoare = $produs_factura->pret_unitar * $produs_factura->cantitate;
                $produs_factura->valoare_tva = $produs['pret'] - $produs_factura->valoare;
                $produs_factura->save();
            }
            
            // $pdf = \PDF::loadView('genereaza-factura-client.export.factura', compact('factura', 'produse_vandute'))
            //     ->setPaper('a4', 'portrait');
            // return $pdf->stream('Factura ' . $factura->firma . \Carbon\Carbon::now()->isoFormat('D.MM.YYYY') . '.pdf');

            // dd($factura);
        

            return redirect('/produse/generare-factura-client/' . $factura->id . '/export-pdf');
        // } else {
        //     return redirect('/produse/vanzari');
        }
        
    }

    public function exportPDF(Request $request, $factura_id)
    {
        $factura = \App\Factura::where('id', $factura_id)->first();
            $pdf = \PDF::loadView('genereaza-factura-client.export.factura', compact('factura', 'produse_vandute'))
                ->setPaper('a4', 'portrait');
            return $pdf->stream('Factura ' . $factura->firma . \Carbon\Carbon::now()->isoFormat('D.MM.YYYY') . '.pdf');
    }
}
