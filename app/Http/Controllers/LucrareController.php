<?php

namespace App\Http\Controllers;

use App\Lucrare;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class LucrareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search_categorie = $request->search_categorie;
        $search_producator = $request->search_producator;
        $search_model = $request->search_model;
        $search_problema = $request->search_problema;

        $lucrari = Lucrare::
            when($search_categorie, function ($query, $search_categorie) {
                return $query->where('categorie', 'like', '%' . $search_categorie . '%');
            })
            ->when($search_producator, function ($query, $search_producator) {
                return $query->where('producator', 'like', '%' . $search_producator . '%');
            })
            ->when($search_model, function ($query, $search_model) {
                return $query->where('model', 'like', '%' . $search_model . '%');
            })
            ->when($search_problema, function ($query, $search_problema) {
                return $query->where('problema', 'like', '%' . $search_problema . '%');
            })
            ->latest()
            ->simplePaginate(25);

        $lucrari_selectate_total = Lucrare::
            when($search_categorie, function ($query, $search_categorie) {
                return $query->where('categorie', 'like', '%' . $search_categorie . '%');
            })
            ->when($search_producator, function ($query, $search_producator) {
                return $query->where('producator', 'like', '%' . $search_producator . '%');
            })
            ->when($search_model, function ($query, $search_model) {
                return $query->where('model', 'like', '%' . $search_model . '%');
            })
            ->when($search_problema, function ($query, $search_problema) {
                return $query->where('problema', 'like', '%' . $search_problema . '%');
            })
            ->count();

        return view('lucrari.index', compact('lucrari', 'lucrari_selectate_total', 'search_categorie', 'search_producator', 'search_model', 'search_problema'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lucrari.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lucrare = Lucrare::create($this->validateRequest());

        return redirect('/lucrari')->with('status', 'Lucrarea „' . $lucrare->problema . '” a fost adaugată cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lucrare  $lucrare
     * @return \Illuminate\Http\Response
     */
    public function show(Lucrare $lucrare)
    {
        return view('lucrari.show', compact('lucrare'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lucrare  $lucrare
     * @return \Illuminate\Http\Response
     */
    public function edit(Lucrare $lucrare)
    {
        return view('lucrari.edit', compact('lucrare'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lucrare  $lucrare
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lucrare $lucrare)
    {
        $lucrare->update($this->validateRequest($request));

        return redirect('/lucrari')->with('status', 'Lucrarea „' . $lucrare->problema . '” a fost modificată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lucrare  $lucrare
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lucrare $lucrare)
    {
        $lucrare->delete();
        return redirect('/lucrari')->with('status', 'Lucrarea „' . $lucrare->problema . '" a fost ștearsă cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest()
    {
        return request()->validate([
            'categorie' => 'required|max:200',
            'producator' => 'required|max:200',
            'model' => 'required|max:200',
            'problema' => 'required|max:200',
            'pret' => 'required|integer|between:1,99999',
        ]
        );
    }

    public function vizualizare()
    {
        $lucrari = Lucrare::select('id', 'categorie', 'producator', 'model', 'problema', 'pret')
            ->orderBy('categorie')
            ->orderBy('producator')
            ->orderBy('model')
            ->orderBy('problema')
            ->get();
        // $lucrari = Lucrare::all();
        return view('lucrari.diverse.vizualizare', compact('lucrari'));
    }

    public function actualizare_preturi(Request $request)
    {
        // $request->request->add([
        //     'id' => '7',
        //     'pret' => '99999999',
        // ]);
        $mesaje = [];

        $validator = Validator::make($request->all(),
            [
                'id' => 'exists:lucrari',
                'pret' => 'required|integer|between:1,99999',
            ],
            [
                'id.exists' => 'Lucrarea nu există în baza de date'
            ]
        );

        if ($validator->fails()) {
            // dd($validator->errors());
            // dd($mesaje);

            foreach ($validator->errors()->all() as $key => $eroare) {
                // echo $eroare . '<br>';
                array_push($mesaje, $eroare);
            }
            // dd('stop', $mesaje);
            return response()->json([
                'actualizare_pret_cu_succes' => 0,
                'actualizare_pret_mesaje' => $mesaje
            ]);
        }

        try {
            $lucrare = Lucrare::find($request->id)->update(['pret' => $request->pret]);
            array_push($mesaje, 'Prețul „' . $request->pret . '” a fost actualizat cu succes.');
            return response()->json([
                'actualizare_pret_cu_succes' => 1,
                'actualizare_pret_mesaje' => $mesaje,
            ]);
        }
        catch (\Exception $e) {
            array_push($mesaje, 'Prețul nu a putut fi actualizat.');
            return response()->json([
                'actualizare_pret_cu_succes' => 0,
                'actualizare_pret_mesaje' => $mesaje,
            ]);
        }
    }

    public function actualizare_preturi_global_procentual(Request $request)
    {
        $request->validate(
            [
                'salariati_selectati' => 'required|array|between:1,100',
                'nume_client' => 'required_without_all:functia,traseu,data_ssm_psi,semnat_ssm,semnat_psi,semnat_anexa,semnat_eip|max:200',
                'functia' => 'nullable|max:200',
                'traseu' => 'nullable|max:200',
                'data_ssm_psi' => 'nullable|max:200',
                'semnat_ssm' => 'nullable|max:200',
                'semnat_psi' => 'nullable|max:200',
                'semnat_anexa' => 'nullable|max:200',
                'semnat_eip' => 'nullable|max:200',
            ],
            [
                'salariati_selectati.required' => 'Nu ați selectat nici un salariat!',
                'required_without_all' => 'Nu ați ales nici un câmp de modificat!'
            ]
            );

        $salariati = SsmSalariat::find($request->salariati_selectati);

        foreach ($salariati as $salariat){
            $request->nume_client ? $salariat->nume_client = $request->nume_client : '';
            $request->functia ? $salariat->functia = $request->functia : '';
            $request->traseu ? $salariat->traseu = $request->traseu : '';
            $request->data_ssm_psi ? $salariat->data_ssm_psi = $request->data_ssm_psi : '';
            $request->semnat_ssm ? $salariat->semnat_ssm = $request->semnat_ssm : '';
            $request->semnat_psi ? $salariat->semnat_psi = $request->semnat_psi : '';
            $request->semnat_anexa ? $salariat->semnat_anexa = $request->semnat_anexa : '';
            $request->semnat_eip ? $salariat->semnat_eip = $request->semnat_eip : '';

            $salariat->save();
        }

        return back()->with('status', 'Cei ' . count($salariati) . ' Salariați au fost modificați cu succes!');

    }
}
