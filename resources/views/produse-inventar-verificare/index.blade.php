@extends ('layouts.app')

@section('content')   
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header justify-content-between py-1" style="border-radius: 40px 40px 0px 0px;">
                <div class="col-lg-12 mt-2 mb-0">
                    <h5 class="">
                        {{-- <i class="fas fa-warehouse mr-1"></i> --}}
                        Sume inventar:                         
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
            <div class="col-lg-3 align-self-center">
                <h4 class=" mb-0">
                    <a href="{{ route('produse-inventar-verificare.index') }}"><i class="fas fa-boxes mr-1"></i>Produse inventar</a>
                </h4>
            </div> 
            <div class="col-lg-6" id="">
                <form class="needs-validation" novalidate method="GET" action="{{ route('produse-inventar-verificare.index') }}">
                    @csrf                    
                    <div class="row input-group custom-search-form justify-content-center align-self-end">
                        <div class="col-8 px-0">
                            <input type="text" class="form-control form-control-sm border rounded-pill mb-1 py-0" 
                            id="search_nume" name="search_nume" placeholder="Nume" autofocus
                                    value="{{ $search_nume }}">
                        </div>
                        <div class="col-4 px-0">
                            <input type="text" class="form-control form-control-sm border rounded-pill mb-1 py-0" 
                            id="search_cod_de_bare" name="search_cod_de_bare" placeholder="Cod de bare" autofocus
                                    value="{{ $search_cod_de_bare }}">
                        </div>
                        <button class="btn btn-sm btn-primary col-md-4 mr-1 border border-dark rounded-pill" type="submit">
                            <i class="fas fa-search text-white mr-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-pill" href="{{ route('produse-inventar-verificare.index') }}" role="button">
                            <i class="fas fa-undo text-white mr-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
            <div class="col-lg-2 text-right px-0 align-self-center">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-pill col-md-8" href="{{ route('produse-inventar-verificare.create') }}" role="button">
                    <i class="fas fa-plus-square text-white mr-1"></i>Adaugă
                </a>
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @include ('errors')

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded"> 
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>Nr. Crt.</th>
                            <th class="">Produs</th>
                            <th class="">Cod de bare</th>
                            <th class="text-center">Cantitatea</th>
                            <th class="text-center">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>               
                        @forelse ($produse_inventar as $produs_inventar) 
                            <tr>                  
                                <td align="">
                                    {{ ($produse_inventar ->currentpage()-1) * $produse_inventar ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    {{-- <a class="" data-toggle="collapse" href="#collapse{{ $produs_inventar->id }}" role="button" 
                                        aria-expanded="false" aria-controls="collapse{{ $produs_inventar->id }}"> --}}
                                    {{-- <a href="{{ isset($produs_inventar->produs) ? $produs_inventar->produs->path() : ''}}"> --}}
                                        <b>{{ $produs_inventar->produs->nume ?? '' }}</b>
                                    {{-- </a> --}}
                                </td>
                                <td>
                                    {{ $produs_inventar->produs->cod_de_bare ?? '' }}
                                </td>
                                <td class="text-center">
                                    {{ $produs_inventar->cantitate }}
                                </td>
                                <td class="d-flex justify-content-end">      
                                    <div style="flex" class="">
                                        <a class="flex" 
                                            href="{{ $produs_inventar->path() }}/modifica"
                                            title="Editează Produsul"
                                            >
                                            <span class="badge badge-primary">Modifică</span>
                                        </a>
                                        <a 
                                            href="#" 
                                            data-toggle="modal" 
                                            data-target="#stergeProdusInventar{{ $produs_inventar->id }}"
                                            title="Șterge Produs Inventar"
                                            >
                                            <span class="badge badge-danger">Șterge</span>
                                        </a>
                                            <div class="modal fade text-dark" id="stergeProdusInventar{{ $produs_inventar->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title text-white" id="exampleModalLabel">
                                                            Produs Inventar: <b>{{ $produs_inventar->produs->nume }}</b>
                                                        </h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" style="text-align:left;">
                                                        Ești sigur ca vrei să ștergi produsul din lista de inventar?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                                        
                                                        <form method="POST" action="{{ $produs_inventar->path() }}">
                                                            @method('DELETE')  
                                                            @csrf   
                                                            <button 
                                                                type="submit" 
                                                                class="btn btn-danger"  
                                                                >
                                                                Șterge Produsul
                                                            </button>                    
                                                        </form>
                                                    
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div> 
                                </td>
                            </tr>  
                        @empty
                            <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div>
                        @endforelse
                        </tbody>
                </table>
            </div>

                <nav>
                    <ul class="pagination pagination-sm justify-content-center">
                        {{-- {{$produse_inventare->links()}} --}}
                        {{$produse_inventar->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection