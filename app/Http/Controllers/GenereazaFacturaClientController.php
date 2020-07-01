<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GenereazaFacturaClientController extends Controller
{
    public function completareDate(Request $request)
    {
        $produse_vandute = $request->session()->get('produse_vandute');

        $clienti = \App\Client::all();

        if (isset($produse_vandute)){
            return view('genereaza-factura-client.completare-date', compact('produse_vandute', 'clienti'));
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

            $client = \App\Client::where('id', $request->client_deja_inregistrat)->first();
            if (isset($client)){
                $client->update($validatedData);
            } else {
                $client = \App\Client::make($validatedData);
                $client->save();
            }
            // $produse->update($request->except(['pret', 'cantitate', 'categorie_produs_id']));

            // $client = \App\Client::make($validatedData);
            // $client->save();

            $factura = \App\Factura::make($validatedData);
            $factura->client_id = $client->id;
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
                
                // Calcul TVA la total
                // $produs_factura->valoare_tva = number_format(round_up($produs['pret'] / 1.19), 2);
                // $produs_factura->valoare = $produs['pret'] $produs_factura->valoare_tva;
                // $produs_factura->pret_unitar = number_format(($produs_factura->valoare / $produs['cantitate']) , 2);

                // Calcul pret per bucata
                $produs_factura->pret_unitar = number_format(round_up(($produs['pret'] / $produs['cantitate'] / 1.19), 2), 2);
                $produs_factura->valoare = $produs_factura->pret_unitar * $produs_factura->cantitate;
                $produs_factura->valoare_tva = $produs['pret'] - $produs_factura->valoare;

                $produs_factura->save();
            }        

            // return redirect('/produse/generare-factura-client/' . $factura->id . '/export-pdf');
            return redirect('facturi');
        }
        
    }

    public function exportPDF(Request $request, $factura_id)
    {
        
        if ($request->view_type === 'export-html') {
            $factura = \App\Factura::where('id', $factura_id)->first();
            return view('genereaza-factura-client.export.factura', compact('factura', 'produse_vandute'));
        } elseif ($request->view_type === 'export-pdf') {
            $factura = \App\Factura::where('id', $factura_id)->first();
                $pdf = \PDF::loadView('genereaza-factura-client.export.factura', compact('factura', 'produse_vandute'))
                    ->setPaper('a4', 'portrait');
                return $pdf->download('Factura ' . $factura->firma . \Carbon\Carbon::now()->isoFormat('D.MM.YYYY') . '.pdf');
        }
    }
}
