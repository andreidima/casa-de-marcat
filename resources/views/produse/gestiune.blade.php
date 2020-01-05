@extends ('layouts.app')

@section('content')  

    <div class="container card">
            <div class="row card-header">
                <div class="mt-2 mb-0">
                    <h4 class=""><i class="fas fa-list-ul mr-1"></i>Gestiune - {{ $suma_totala }} lei</h4>
                </div> 
            </div>
            <div class="card-body" id="app1">
                <div class="row d-flex">
                        
                    @if (session()->has('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                {{-- @foreach ($gestiune as $categorie)
                    <div class="col-sm-3 mb-2" style="font-size: 1.3em">
                        <p>            
                            <span class="badge badge-dark"
                                 style="background-color:darkcyan;"
                            >
                                {{ \Illuminate\Support\Str::limit($categorie->nume, 22, $end='...') }}
                                {{ number_format($categorie->pret,0) }} lei = 
                                <span class="badge text-white m-0" style="background-color:#e66800; font-size: 1em;">
                                    {{ $categorie->cantitate }}
                                </span>
                            </span>
                        </p>
                    </div>
                @endforeach --}}
                @foreach ($subcategorii as $subcategorie)
                @foreach ($subcategorie->produse->sortBy('pret')->groupby('pret') as $produse)
                    <div class="col-sm-3 mb-2 px-0">
                        <a class="" data-toggle="collapse" href="#collapse{{ $subcategorie->id }}pret{{ number_format($produse->first()->pret,0) }}" role="button" 
                            aria-expanded="false" aria-controls="collapse{{ $subcategorie->id }}pret{{ number_format($produse->first()->pret,0) }}"
                            style="font-size: 1.3em"
                            >
                            <span class="badge badge-dark"
                                 style="background-color:darkcyan;"
                            >
                                {{ \Illuminate\Support\Str::limit($subcategorie->nume, 22, $end='...') }}
                                {{ number_format($produse->first()->pret,0) }} lei = 
                                <span class="badge text-white m-0" style="background-color:#e66800; font-size: 1em;">
                                    {{ $produse->sum('cantitate') }}
                                </span>
                            </span>
                        </a>
                        <div class="collapse bg-white " 
                            id="collapse{{ $subcategorie->id }}pret{{ number_format($produse->first()->pret,0) }}"
                            style="font-size: 0.8em"
                            >
                            @foreach ($produse as $produs)
                                {{ $produs->nume }} = {{ $produs->cantitate }}
                                <br>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                @endforeach
                </div>

            </div>
    </div>
@endsection
