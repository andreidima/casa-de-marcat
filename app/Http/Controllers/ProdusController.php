<?php

namespace App\Http\Controllers;

use App\Produs;
use App\Casa;
use App\ProdusIstoric;
use App\ProdusCantitateIstoric;
use App\ProdusVandut;
use App\CategoriiProduse;
use App\SubcategoriiProduse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;

class ProdusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_cod_de_bare = \Request::get('search_cod_de_bare'); //<-- we use global request to get the param of URI   
        $search_nume = \Request::get('search_nume'); //<-- we use global request to get the param of URI   
        $search_subcategorie_produs_id = \Request::get('search_subcategorie_produs_id'); //<-- we use global request to get the param of URI  
        $search_pret = \Request::get('search_pret'); //<-- we use global request to get the param of URI       
        $search_data_inceput = \Request::get('search_data_inceput');
        $search_data_sfarsit = \Request::get('search_data_sfarsit');
        $produse = Produs::
                when($search_cod_de_bare, function ($query, $search_cod_de_bare) {
                    return $query->where('cod_de_bare', 'like', $search_cod_de_bare);
                })
            ->when($search_nume, function ($query, $search_nume) {
                    return $query->where('nume', 'like', '%' . str_replace(' ', '%', $search_nume) . '%');
                })
            ->when($search_subcategorie_produs_id, function ($query, $search_subcategorie_produs_id) {
                    return $query->where('subcategorie_produs_id', $search_subcategorie_produs_id);
                })
            ->when($search_pret, function ($query, $search_pret) {
                    return $query->where('pret', 'like', $search_pret . '%');
                })
            ->when($search_data_inceput, function ($query, $search_data_inceput) {
                return $query->whereDate('created_at', '>=', $search_data_inceput);
            })
            ->when($search_data_sfarsit, function ($query, $search_data_sfarsit) {
                // return $query->whereDate('created_at', '<=', \Carbon\Carbon::parse($search_data_sfarsit)->addDay());
                return $query->whereDate('created_at', '<=', $search_data_sfarsit);
            })
            ->latest()
            ->Paginate(25);

        $subcategorii = SubcategoriiProduse::select('id', 'nume')->get()->sortBy('nume');
                
        // dd($subcategorii);

        return view('produse.index', compact(
                'produse', 'search_cod_de_bare', 'search_nume', 'search_subcategorie_produs_id', 'search_pret', 'subcategorii',
                'search_data_inceput', 'search_data_sfarsit'
            ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorii_produs = CategoriiProduse::select('id', 'nume')
            ->orderBy('nume')
            ->get();
        $cod_de_bare = \App\CodDeBare::select('prefix', 'numar')
            ->first();
        // dd($cod_de_bare);
        return view('produse.create', compact('categorii_produs', 'cod_de_bare'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $produse = Produs::make($this->validateRequest($request));
        $produse_istoric = ProdusIstoric::make($this->validateRequest($request));
        // $this->authorize('update', $proiecte);
        $produse->cantitate = 0;
        $produse_istoric->cantitate = 0;
        // dd($produse, $produse_istoric);
        $produse->save();
        
        $produse_istoric->produs_id = $produse->id;
        $produse_istoric->user = auth()->user()->id;
        $produse_istoric->operatiune = 'adaugare';
        $produse_istoric->save();

        $produse_cantitati_istoric = ProdusCantitateIstoric::make();
        $produse_cantitati_istoric->produs_id = $produse->id;
        $produse_cantitati_istoric->cantitate = $produse->cantitate;
        $produse_cantitati_istoric->operatiune = 'adaugare';
        $produse_cantitati_istoric->save();

        $cod_de_bare = \App\CodDeBare::select('prefix', 'numar')
            ->first();
        if ($produse->cod_de_bare == $cod_de_bare->prefix . $cod_de_bare->numar) {
            DB::table('cod_de_bare')
                ->where('id', 1)
                ->update(['numar' => $cod_de_bare->numar += 1]);
        }

        switch ($request->input('action')) {
            case 'salvare':
                return redirect('/produse')->with('status', 'Produsul "' . $produse->nume . '" a fost adăugat cu succes!');
            break;

            case 'adaugari_multiple':
                $categorii_produs = CategoriiProduse::select('id', 'nume')
                    ->orderBy('nume')
                    ->get();
                $categorie = $produse->subcategorie->categorie_produs_id;
                $subcategorie = $produse->subcategorie->id;

                // dd($categorie, $subcategorie);
                \Session::flash('status', 'Produsul "' . $produse->nume . '" a fost adăugat cu succes!');
                // return redirect('/produse.create')->with('status', 'Produsul "' . $produse->nume . '" a fost adăugat cu succes!');
                return view('produse.create', compact('categorii_produs', 'cod_de_bare', 'categorie', 'subcategorie'));
                    // ->with('status', 'Produsul "' . $produse->nume . '" a fost adăugat cu succes!');
                break;
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Produs  $produs
     * @return \Illuminate\Http\Response
     */
    public function show(Produs $produse)
    {
        return view('produse.show', compact('produse'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Produs  $produs
     * @return \Illuminate\Http\Response
     */
    public function edit(Produs $produse)
    {
        $categorii_produs = CategoriiProduse::select('id', 'nume')
            ->orderBy('nume')
            ->get();
        return view('produse.edit', compact('produse', 'categorii_produs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Produs  $produs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produs $produse)
    {
        // $this->authorize('update', $proiecte);
        $produse_istoric = ProdusIstoric::make($this->validateRequest($request, $produse));

        $produse_cantitati_istoric = ProdusCantitateIstoric::make();
        $produse_cantitati_istoric->cantitate_initiala = $produse->cantitate;
        
        if (auth()->user()->role === ('admin')){
            $produse->update($this->validateRequest($request, $produse));
        } else{
            $this->validateRequest($request, $produse);
            // dd($request->except(['pret', 'cantitate']));
            $produse->update($request->except(['pret', 'cantitate', 'categorie_produs_id']));
            // $produse = $produse->except(['pret', 'cantitate']);
            // dd($produse);
            // $produse->update();
        }        
        
        $produse_istoric->produs_id = $produse->id;
        $produse_istoric->user = auth()->user()->id;
        $produse_istoric->operatiune = 'modificare';
        $produse_istoric->save();

        $produse_cantitati_istoric->produs_id = $produse->id;
        $produse_cantitati_istoric->cantitate = $produse->cantitate;
        $produse_cantitati_istoric->operatiune = 'modificare';
        $produse_cantitati_istoric->save();

        return redirect('/produse')->with('status', 'Produsul "'.$produse->nume.'" a fost modificat cu succes!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Produs  $produs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produs $produse)
    {
        // $this->authorize('delete', $produse);
        // dd(Produs::where('id', $produse->id)->has('produse_vandute')->get());
        // if ($produse->has('produse_vandute'))
        // return redirect('/produse')->with('status', 'Produsul "' . $produse->nume . '" a fost șters cu succes!');
        // dd($produse->produse_vandute->count());
        if (auth()->user()->role !== ('admin')){
            return back();
        }elseif ($produse->produse_vandute->count() > 0) {
            return redirect('/produse')
                ->with('eroare', 'Produsul "' . $produse->nume . '" nu poate fi șters pentru că are un număr de ' . $produse->produse_vandute->count() . ' vânzări!');
        }elseif ($produse->produse_stocuri->count() > 0) {
            return redirect('/produse')
                ->with('eroare', 'Produsul "' . $produse->nume . '" nu poate fi șters pentru că are un număr de ' . $produse->produse_stocuri->count() . ' stocuri!');
        } else{
            $produse->delete();
            $produse_istoric = ProdusIstoric::make($produse->toArray());
            unset($produse_istoric['id'], $produse_istoric['created_at'], $produse_istoric['updated_at'], $produse_istoric['produse_vandute']);
            $produse_istoric->produs_id = $produse->id;
            $produse_istoric->user = auth()->user()->id;
            $produse_istoric->operatiune = 'stergere';
            $produse_istoric->save();
            // dd($produse, $produse_istoric);

            ProdusCantitateIstoric::where('produs_id', $produse->id)->delete();
            // $produse_cantitati_istoric = ProdusCantitateIstoric::make();
            // $produse_cantitati_istoric->produs_id = $produse->id;
            // $produse_cantitati_istoric->cantitate = null;
            // $produse_cantitati_istoric->operatiune = 'stergere';
            // $produse_cantitati_istoric->save();
            
            
            return redirect('/produse')->with('status', 'Produsul "' . $produse->nume . '" a fost șters cu succes!');
        }
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request, $produse = null)
    {
        // dd ($request->_method);
        return request()->validate([
            'nume' =>['required', 'max:250'],
            'subcategorie_produs_id' => ['required', 'numeric', 'between:1,999'],
            // 'pret_de_achizitie' => [ 'nullable', 'regex:/^(\d+(.\d{1,2})?)?$/', 'max:9999999'],
            // 'pret' => [ 'nullable', 'regex:/^(\d+(.\d{1,2})?)?$/', 'max:9999999'],
            'pret_de_achizitie' => ['nullable', 'numeric', 'between:0.01,99999.99'],
            'pret' => ['required', 'numeric', 'between:0.00,99999.99'],
            // 'cantitate' => [ 'required', 'required', 'numeric', 'between:0,999999999'],
            'cod_de_bare' => ['nullable', 'max:20', 'unique:produse,cod_de_bare,' . ($produse->id ?? '')],
            'imei' => ['nullable', 'max:50'],
            'localizare' => ['nullable', 'max:250'],
            'descriere' => ['nullable', 'max:250'],
        ],
        [            
            'pret_de_achizitie.regex' => 'Câmpul Preț de achiziție nu este completat corect.',
            'pret.regex' => 'Câmpul Preț de vânzare nu este completat corect.',
        ]
        );
    }

    /**
     * Vanzare de produse. Scaderea cantitatii produsului
     *
     * @param  \App\Produs  $produs
     * @return \Illuminate\Http\Response
     */
    public function vanzari(Request $request)
    {         
        return view ('produse.vanzari');
    }

    public function vanzariDescarcaProdus(Request $request)
    { 
        $produs = Produs::where('cod_de_bare', $request->cod_de_bare)->first();

        $validatedData = $request->validate([
            'cod_de_bare' => ['bail', 'required',
                    Rule::exists('produse')->where(function ($query) use($request) {
                        return $query->where('cod_de_bare', $request->cod_de_bare);
                    }),        
                ],
            'nr_de_bucati' => [ 'required', 'numeric', 'min:1', (isset($produs->cantitate) ? 'max:' . ($produs->cantitate) : '')],
            'pret' => ['required', 'numeric', 'between:0.00,99999.99'],
            'card' => ['nullable'],
            'emag' => ['nullable'],
            'detalii' => ['nullable', 'max:250'],
        ]);


        // if (isset($request->cod_de_bare)){
        //     $produs = Produs::where('cod_de_bare', $request->cod_de_bare)->first();

            if (isset($produs->id)){
                // if (!is_numeric($request->nr_de_bucati) || $request->nr_de_bucati < 1 || $request->nr_de_bucati != round($request->nr_de_bucati)) {
                //     return redirect ('produse/vanzari')->with('error', 'Numărul de bucăți nu este o valoare întreagă pozitivă: "' . $request->nr_de_bucati . '"!');
                // }
                // if (($produs->cantitate - $request->nr_de_bucati) < 0){
                //     return redirect ('produse/vanzari')->with('error', 'Sunt mai puțin de "' . $request->nr_de_bucati . '" produse pe stoc!');
                // }
                $produse_cantitati_istoric = ProdusCantitateIstoric::make();
                $produse_cantitati_istoric->cantitate_initiala = $produs->cantitate;

                $produs->cantitate = $produs->cantitate - $request->nr_de_bucati;
                $produs->update();

                $produse_istoric = ProdusIstoric::make($produs->toArray());
                unset($produse_istoric['id'], $produse_istoric['created_at'], $produse_istoric['updated_at']);
                $produse_istoric->produs_id = $produs->id;
                $produse_istoric->user = auth()->user()->id;
                $produse_istoric->operatiune = 'vanzare';
                $produse_istoric->save();

                $produse_cantitati_istoric->produs_id = $produs->id;
                $produse_cantitati_istoric->cantitate = $produs->cantitate;
                $produse_cantitati_istoric->operatiune = 'vanzare';
                $produse_cantitati_istoric->save();

                $request->session()->has('produse_vandute') ?? $request->session()->put('produse_vandute', []);
                // $request->session()->push('produse_vandute', '' . $request->nr_de_bucati . ' buc. ' . $produs->nume . ' - ' . $request->pret . ' lei');                
                $request->session()->push('produse_vandute', 
                    [
                        'id' => $produs->id,
                        'nume' => $produs->nume,
                        'um' => 'BUC',
                        'cantitate' => $request->nr_de_bucati,
                        'pret' => $request->pret
                    ]);
                    // '' . $request->nr_de_bucati . ' buc. ' . $produs->nume . ' - ' . $request->pret . ' lei');

                $produs_vandut = ProdusVandut::make();
                $produs_vandut->produs_id = $produs->id;
                $produs_vandut->cantitate = $request->nr_de_bucati;
                $produs_vandut->pret = $request->pret;
                $produs_vandut->card = $request->card;
                $produs_vandut->emag = $request->emag;
                $produs_vandut->detalii = $request->detalii;

                $produs_vandut->save();

                // if (is_null($produs_vandut->card) && is_null($produs_vandut->emag)){
                //     $casa = Casa::make();
                //     $casa->referinta_tabel = 'produse_vandute';
                //     $casa->referinta_id = $produs_vandut->id;
                //     $casa->suma_initiala = Casa::latest()->first()->suma;
                //     $casa->suma = $casa->suma_initiala + ($produs_vandut->cantitate * $produs_vandut->pret);
                //     $casa->operatiune = 'Vânzare';
                //     $casa->save();
                // }

                return redirect ('produse/vanzari')->with('success', 'A fost vândut ' . $request->nr_de_bucati . ' buc. "' . $produs->nume . '"!');
            }
            // } else{
            //     return redirect ('produse/vanzari')->with('error', 'Nu se află nici un produs in baza de date, care să aibă codul: "' . $request->cod_de_bare . '"!');
            // }
            // } else {
            //     return redirect ('produse/vanzari')->with('warning', 'Introdu un cod de bare!');
            // } 
        
        return view ('produse.vanzari');
    }

    public function vanzariGolesteCos(Request $request)
    {         
        $request->session()->forget('produse_vandute');
        return view ('produse/vanzari');
    }

    /**
     * Generare barcode
     *
     * @param  \App\Produs  $produs
     * @return \Illuminate\Http\Response
     */
    public function pdfExportBarcode(Request $request, Produs $produse)
    {
        if ($request->view_type === 'barcode-html') {
            return view('produse.export.barcode-pdf', compact('produse'));
        } elseif ($request->view_type === 'barcode-pdf') {
            $pdf = \PDF::loadView('produse.export.barcode-pdf', compact('produse'))
                ->setPaper('a7', 'landscape');
            // return $pdf->download('Rezervare ' . $produse->nume . '.pdf');
            return $pdf->stream();
        }
    }

    /**
     * Returnarea oraselor de sosire
     */
    public function axios_date_produs(Request $request)
    {
        $pret = '';
        $subcategorii = '';
        // $raspuns = '';
        switch ($_GET['request']) {
            case 'pret':
                $produs = Produs::select('id', 'cod_de_bare', 'pret')
                    ->where('cod_de_bare', $request->cod_de_bare)
                    ->first();
                // $pret = (isset($produs->pret) ? $produs->pret : 0);
                $pret = $produs->pret ?? '';
                break;
            case 'subcategorii':
                $subcategorii = SubcategoriiProduse::select('id', 'categorie_produs_id', 'nume')
                    ->where('categorie_produs_id', $request->categorie)
                    ->orderBy('nume')
                    ->get();
                break;                   
            default:
                break;
        }
        return response()->json([
            'pret' => $pret,
            'subcategorii' => $subcategorii,
        ]);
    }
    /**
     * Gestiune
     */
    public function gestiune(Request $request)
    {
        // $gestiune = Produs::join('subcategorii_produse', 'produse.subcategorie_produs_id', '=', 'subcategorii_produse.id')
        //     ->select(
        //         'pret', DB::raw('SUM(cantitate) as cantitate'), 
        //         'subcategorii_produse.nume')
        //     ->groupBy('subcategorii_produse.nume', 'pret')
        //     ->orderBy('subcategorii_produse.nume')
        //     ->orderBy('pret')
        //     ->get();

        $suma['telefoane_noi'] = Produs::whereHas('subcategorie', function ($query) {
                    $query->where('categorie_produs_id', 1);
                })
            ->sum(DB::raw('cantitate * pret'));
        $suma['telefoane_consignatie'] = Produs::whereHas('subcategorie', function ($query) {
                    $query->where('categorie_produs_id', 2);
                })
            ->sum(DB::raw('cantitate * pret'));
        $suma['accesorii_telefoane'] = Produs::whereHas('subcategorie', function ($query) {
                    $query->where('categorie_produs_id', 3);
                })
            ->sum(DB::raw('cantitate * pret'));
        $suma['suma_totala'] = Produs::where('subcategorie_produs_id', '<>', '38')
            ->sum(DB::raw('cantitate * pret'));
  
        // $subcategorii = SubcategoriiProduse::with('produse')
        //     ->select('id', 'nume', 'categorie_produs_id')
        //     ->orderBy('nume')
        //     ->get();

        $categorii = CategoriiProduse::with('subcategorii', 'subcategorii.produse')
            ->select('id', 'nume')
            ->where('id', '<>' ,'4')
            // ->groupBy('subcategorii.nume')
            // ->orderBy('subcategorii.nume')
            ->orderBy('nume')
            ->get();

        // return view('produse.gestiune', compact('gestiune', 'suma', 'subcategorii'));
        return view('produse.gestiune', compact('categorii', 'suma'));
    }

    /**
     * Lista inventar
     *
     * @param  \App\Produs  $produs
     * @return \Illuminate\Http\Response
     */
    public function pdfExportListaInventar(Request $request)
    {
        $categorii = CategoriiProduse::with('subcategorii', 'subcategorii.produse')
            ->select('id', 'nume')
            ->where('id', '<>' ,'4')
            // ->groupBy('subcategorii.nume')
            // ->orderBy('subcategorii.nume')
            ->orderBy('nume')
            ->get();

        if ($request->view_type === 'lista-inventar-html') {
            return view('produse.export.lista-inventar-pdf', compact('categorii'));
        } elseif ($request->view_type === 'lista-inventar-pdf') {
            $pdf = \PDF::loadView('produse.export.lista-inventar-pdf', compact('categorii'))
                ->setPaper('a4', 'portrait');
            return $pdf->download('Lista inventar ' . \Carbon\Carbon::now()->isoFormat('D.MM.YYYY') . '.pdf');
            // return $pdf->stream();
        }
    }

    // Export produse pentru Vali de pus pe site la vanzare
    public function pdfExportListaProduseVali(Request $request)
    {
        $produse = Produs::
            with('subcategorie', 'subcategorie.categorie')
            // ->select('id', 'nume', 'subcategorie.nume')
            // ->take(10)
            ->get();

        if ($request->view_type === 'html') {
            return view('produse.export.lista-inventar-produse-vali-pdf', compact('produse'));
        } elseif ($request->view_type === 'pdf') {
            $pdf = \PDF::loadView('produse.export.lista-inventar-produse-vali-pdf', compact('produse'))
                ->setPaper('a4', 'portrait');
            return $pdf->download('Lista inventar ' . \Carbon\Carbon::now()->isoFormat('D.MM.YYYY') . '.pdf');
            // return $pdf->stream();
        }
    }
}
