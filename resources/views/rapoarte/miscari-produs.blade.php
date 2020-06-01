@extends ('layouts.app')

@section('content')   
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header justify-content-between py-1" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3 align-self-center">
                <h4 class=" mb-0">
                    <a href="{{ route('miscari.produs') }}"><i class="fas fa-box mr-1"></i>Mișcări produs</a>
                </h4>
            </div> 
            <div class="col-lg-8" id="">
                <form class="needs-validation" novalidate method="GET" action="{{ route('miscari.produs') }}">
                    @csrf                    
                    <div class="row input-group custom-search-form justify-content-end">
                        <div class="col-md-6 px-0 mx-0">
                            <input type="text" class="form-control form-control-sm border rounded-pill mb-1 py-0" 
                            id="search_nume" name="search_nume" placeholder="Nume" autofocus
                                    value="{{ $search_nume }}">
                        </div>                        
                        <div class="col-md-3 px-0 mx-0">
                            <button class="btn btn-sm btn-primary col-md-12 mr-1 border border-dark rounded-pill" type="submit">
                                <i class="fas fa-search text-white mr-1"></i>Caută
                            </button>
                        </div>                        
                        <div class="col-md-3 px-0 mx-0">
                            <a class="btn btn-sm bg-secondary text-white col-md-12 border border-dark rounded-pill" href="{{ route('miscari.produs') }}" role="button">
                                <i class="fas fa-undo text-white mr-1"></i>Resetează căutarea
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            {{-- <div class="col-lg-3 text-right"> --}}
                {{-- <a class="btn btn-sm bg-success text-white border border-dark rounded-pill col-md-8" href="{{ route('clienti.create') }}" role="button">
                    <i class="fas fa-plus-square text-white mr-1"></i>Adaugă client
                </a> --}}
            {{-- </div>  --}}
        </div>

        <div class="card-body px-0 py-3">

            @include ('errors')

                <div class="col-lg-12 mb-3 py-0">
                    <b>Legendă:</b>
                        {{-- <span class="badge badge-secondary mx-1" style="font-size: 1em">
                            Stoc vechi
                        </span>
                        <span class="badge badge-success mx-1" style="font-size: 1em">
                            Produs nou
                        </span> --}}
                        <span class="badge badge-success mx-1" style="font-size: 1em">
                            Suplimentare/ Modificare/ Ștergere stoc
                        </span>
                        <span class="badge badge-danger mx-1" style="font-size: 1em">
                            Vânzare
                        </span>
                        <span class="badge badge-warning mx-1" style="font-size: 1em">
                            Vânzare anulată
                        </span>
                        <span class="badge badge-primary mx-1" style="font-size: 1em">
                            Stoc final
                        </span>
                </div>

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded"> 
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>Nr. Crt.</th>
                            <th class="">Produs</th>
                            <th class="">Barcode</th>
                            {{-- <th class="text-center">Operațiune</th> --}}
                            <th class="text-center" colspan="2">Cantitate</th>
                            {{-- <th class="text-center">Modificare</th> --}}
                            <th class="text-right">Data</th>
                        </tr>
                    </thead>
                    <tbody>     
                        @forelse ($produse as $produs) 
                            <tr>                  
                                <td align="">
                                    {{ ($produse ->currentpage()-1) * $produse ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    {{-- <a class="" data-toggle="collapse" href="#collapse{{ $produs->id }}" role="button" 
                                        aria-expanded="false" aria-controls="collapse{{ $produs->id }}"> --}}
                                    
                                        <b>{{ $produs->nume ?? '' }}</b>
                                    
                                    @isset($produs->detalii)
                                     - {{ $produs->detalii }}
                                    @endisset
                                </td>
                                <td>                                    
                                    <b>{{ $produs->cod_de_bare }}</b>
                                </td>
                                <td class="text-center">
                                    @isset($produs->cantitate_initiala)
                                        @if($produs->operatiune == "modificare")
                                            <span class="badge badge-success" style="font-size: 1em">
                                                + {{ $produs->cantitate - $produs->cantitate_initiala }}
                                            </span>
                                        @elseif($produs->operatiune == "suplimentare stoc")
                                            <span class="badge badge-success" style="font-size: 1em">
                                                + {{ $produs->cantitate - $produs->cantitate_initiala }}
                                            </span>
                                        @elseif($produs->operatiune == "modificare stoc")
                                            <span class="badge badge-success" style="font-size: 1em">
                                                + {{ $produs->cantitate - $produs->cantitate_initiala }}
                                            </span>
                                        @elseif($produs->operatiune == "stergere stoc")
                                            <span class="badge badge-success" style="font-size: 1em">
                                                + {{ $produs->cantitate - $produs->cantitate_initiala }}
                                            </span>
                                        @elseif($produs->operatiune == "vanzare")
                                            <span class="badge badge-danger" style="font-size: 1em">
                                                - {{ $produs->cantitate_initiala - $produs->cantitate }}
                                            </span>
                                        @elseif($produs->operatiune == "vanzare stearsa")
                                            <span class="badge badge-warning" style="font-size: 1em">
                                                + {{ $produs->cantitate - $produs->cantitate_initiala }}
                                            </span>
                                        @endif   
                                    @endif
                                </td>
                                <td class="text-center">
                                    @isset($produs->cantitate_initiala)
                                        <span class="badge badge-primary" style="font-size: 1em">
                                            =
                                    @else 
                                        <span class="badge badge-primary" style="font-size: 1em">
                                    @endif
                                            {{ $produs->cantitate }}
                                        </span>        
                                </td>
                                {{-- <td>
                                    {{ $produs->operatiune }}
                                </td> --}}
                                <td class="text-right">
                                    {{ \Carbon\Carbon::parse($produs->created_at)->isoFormat('HH:mm - DD.MM.YYYY') ?? '' }}
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
                        {{-- {{$produse_vandute->links()}} --}}
                        {{$produse->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection