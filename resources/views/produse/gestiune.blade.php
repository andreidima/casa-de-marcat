@extends ('layouts.app')

@section('content')  

    <div class="container card">
            <div class="row card-header">
                <div class="mt-2 mb-0">
                    <h5 class="">
                        <i class="fas fa-warehouse mr-1"></i>
                        Gestiune:                         
                        <span class="badge badge-dark"
                                {{-- style="background-color:;" --}}
                        >
                            Telefoane noi = 
                            <span class="badge text-white m-0" style="background-color:#e66800; font-size: 1em;">
                                    {{ $suma['telefoane_noi'] }}
                            </span>
                            lei
                        </span>
                        +
                        <span class="badge badge-dark"
                                {{-- style="background-color:#e80000;" --}}
                        >
                            Telefoane consignație = 
                            <span class="badge text-white m-0" style="background-color:#e66800; font-size: 1em;">
                                    {{ $suma['telefoane_consignatie'] }}
                            </span>
                            lei
                        </span>
                        +
                        <span class="badge badge-dark"
                                {{-- style="background-color:darkcyan;" --}}
                        >
                            Accesorii telefoane și piese = 
                            <span class="badge text-white m-0" style="background-color:#e66800; font-size: 1em;">
                                    {{ $suma['accesorii_telefoane'] }}
                            </span>
                            lei
                        </span>
                        =    
                        <span class="badge badge-dark"
                                {{-- style="background-color:darkcyan;" --}}
                        >         
                            <span class="badge text-white m-0" style="background-color:#e66800; font-size: 1em;">
                                    {{ $suma['suma_totala'] }}
                            </span>        
                            lei   
                        </span>
                    </h5>
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
                {{-- @foreach ($subcategorii as $subcategorie)
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
                            style="font-size: 1em"
                            >
                            @foreach ($produse as $produs)
                                <span class="badge badge-dark"
                                >
                                    {{ $produs->nume }} = 
                                    <span class="badge text-white m-0" style="background-color:#e66800; font-size: 1em;">
                                            {{ $produs->cantitate }}
                                    </span>
                                    <span class="badge badge-primary m-0" style="font-size: 1em;">
                                        <a href="{{ $produs->path() }}/modifica" target="_blank">
                                            <i class="fas fa-pen text-white"></i>
                                        </a> 
                                    </span>
                                </span>
                                <span class="badge badge-primary text-white"
                                >                                   
                                </span>
                                <br>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                @endforeach --}}
                @foreach ($categorii as $categorie)
                    {{-- <div class="col-sm-12 mb-2 px-0">
                        <span class="badge badge-dark"
                            style="font-size: 1.3em"
                        >
                            {{$categorie->nume}}
                        </span>
                    </div> --}}
                        @foreach ($categorie->subcategorii->sortBy('nume') as $subcategorie)
                            @if ($categorie->id === 3)
                    <div class="card col-sm-12 my-4 shadow">
                                <div class="card-header">
                                    {{-- <span class="badge badge-secondary" --}}
                                        {{-- style="background-color:darkcyan;" --}}
                                        {{-- style="font-size: 1.1em"
                                    > --}}
                                        <h4 class="mb-0">
                                            {{$categorie->nume}} / {{$subcategorie->nume}}
                                        </h4>
                                    {{-- </span> --}}
                                </div>
                            @else
                    <div class="card col-sm-12 my-4 shadow">
                                <div class="card-header">
                                    {{-- <span class="badge badge-secondary" --}}
                                        {{-- style="background-color:darkcyan;" --}}
                                        {{-- style="font-size: 1.1em"
                                    > --}}
                                        <h4 class="mb-0">
                                            {{$subcategorie->nume}}
                                        </h4>
                                    {{-- </span> --}}
                                </div>

                            @endif
                        <div class="card-body">
                            <div class="row">
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
                                            style="font-size: 1em"
                                            >
                                            @foreach ($produse as $produs)
                                                <span class="badge badge-dark"
                                                >
                                                    {{ $produs->nume }} = 
                                                    <span class="badge text-white m-0" style="background-color:#e66800; font-size: 1em;">
                                                            {{ $produs->cantitate }}
                                                    </span>
                                                    <span class="badge badge-primary m-0" style="font-size: 1em;">
                                                        <a href="{{ $produs->path() }}/modifica" target="_blank">
                                                            <i class="fas fa-pen text-white"></i>
                                                        </a> 
                                                    </span>
                                                </span>
                                                <span class="badge badge-primary text-white"
                                                >                                   
                                                </span>
                                                <br>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                    </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
                </div>

            </div>
    </div>
@endsection
