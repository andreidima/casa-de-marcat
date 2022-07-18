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
        request()->validate([
            'search_pret_minim' => 'nullable|numeric|min:0.01|max:999999',
            'search_pret_maxim' => 'nullable|numeric|min:0.01|max:999999',
        ]);

        $search_categorie = $request->search_categorie;
        $search_producator = $request->search_producator;
        $search_model = $request->search_model;
        $search_problema = $request->search_problema;
        $search_pret_minim = $request->search_pret_minim;
        $search_pret_maxim = $request->search_pret_maxim;

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
            ->when($search_pret_minim, function ($query, $search_pret_minim) {
                return $query->where('pret', '>=', $search_pret_minim);
            })
            ->when($search_pret_maxim, function ($query, $search_pret_maxim) {
                return $query->where('pret', '<=', $search_pret_maxim);
            })
            ->latest()
            ->Paginate(25);

        return view('lucrari.index', compact('lucrari', 'search_categorie', 'search_producator', 'search_model', 'search_problema', 'search_pret_minim', 'search_pret_maxim'));
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
            'pret' => 'required|integer|between:0,99999',
        ]
        );
    }

    public function vizualizare()
    {
        $lucrari = Lucrare::select('id', 'categorie', 'producator', 'model', 'problema', 'pret')
            // ->orderBy('categorie')
            ->orderByRaw("FIELD(categorie , 'Telefoane mobile') Desc")
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
                'pret' => 'required|integer|between:0,99999',
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

    public function actualizarePreturiGlobal(Request $request)
    {
        request()->validate([
            'inmultitor' => 'required|numeric|min:0.01|max:10',
            'search_pret_minim' => 'nullable|numeric|min:0.01|max:999999',
            'search_pret_maxim' => 'nullable|numeric|min:0.01|max:999999',
        ]);

        $search_categorie = $request->search_categorie;
        $search_producator = $request->search_producator;
        $search_model = $request->search_model;
        $search_problema = $request->search_problema;
        $search_pret_minim = $request->search_pret_minim;
        $search_pret_maxim = $request->search_pret_maxim;

        $lucrari = Lucrare::select('id', 'pret')
            ->when($search_categorie, function ($query, $search_categorie) {
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
            ->when($search_pret_minim, function ($query, $search_pret_minim) {
                return $query->where('pret', '>=', $search_pret_minim);
            })
            ->when($search_pret_maxim, function ($query, $search_pret_maxim) {
                return $query->where('pret', '<=', $search_pret_maxim);
            })
            ->get();

        // Update multiple records with separate data
        foreach ($lucrari->chunk(1000) as $chunk) {
            $cases = [];
            $ids = [];
            $params = [];
            foreach ($chunk as $lucrare){
                $cases[] = "WHEN {$lucrare->id} then ?";
                $params[] = $lucrare->pret * $request->inmultitor;
                $ids[] = $lucrare->id;
            }
            $ids = implode(',', $ids);
            $cases = implode(' ', $cases);
            if (!empty($ids)) {
                \DB::update("UPDATE lucrari SET `pret` = CASE `id` {$cases} END WHERE `id` in ({$ids})", $params);
            }
        }

        return back()->with('status', 'Succes! Au fost modificate prețurile a ' . $lucrari->count() . ' lucrări.');
    }
}
