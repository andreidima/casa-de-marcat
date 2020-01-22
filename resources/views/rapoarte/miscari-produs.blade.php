@extends ('layouts.app')

@section('content')   
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header justify-content-between py-1" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3 align-self-center">
                <h4 class=" mb-0">
                    <a href="{{ route('miscari.produs') }}"><i class="fas fa-box mr-1"></i>Istoric produs</a>
                </h4>
            </div> 
            <div class="col-lg-8" id="">
                <form class="needs-validation" novalidate method="GET" action="{{ route('miscari.produs') }}">
                    @csrf                    
                    <div class="row input-group custom-search-form justify-content-center align-self-end">
                        <div class="col-md-3">
                            <input type="text" class="form-control form-control-sm border rounded-pill mb-1 py-0" 
                            id="search_nume" name="search_nume" placeholder="Nume" autofocus
                                    value="{{ $search_nume }}">
                        </div>
                        <button class="btn btn-sm btn-primary col-md-4 mr-1 border border-dark rounded-pill" type="submit">
                            <i class="fas fa-search text-white mr-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-pill" href="{{ route('produse-vandute.index') }}" role="button">
                            <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                        </a>
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

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded"> 
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>Nr. Crt.</th>
                            <th class="w-50">Produs</th>
                            <th class="text-center">Cantitatea</th>
                            <th class="text-center">Operațiune</th>
                            <th class="text-right">Data</th>
                        </tr>
                    </thead>
                    <tbody>     
                        @forelse ($produse->first()->cantitati as $cantitate) 
                            <tr>                  
                                <td align="">
                                    {{ ($produse ->currentpage()-1) * $produse ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    {{-- <a class="" data-toggle="collapse" href="#collapse{{ $produs->id }}" role="button" 
                                        aria-expanded="false" aria-controls="collapse{{ $produs->id }}"> --}}
                                    
                                        <b>{{ $produse->first()->nume ?? '' }}</b>
                                    
                                    @isset($produs->detalii)
                                     - {{ $produs->detalii }}
                                    @endisset
                                </td>
                                <td class="text-center">
                                    {{ $cantitate->cantitate }}
                                </td>
                                <td>
                                    {{ $cantitate->operatiune }}
                                </td>
                                <td class="text-right">
                                    {{-- {{ \Carbon\Carbon::parse($produs_vandut->created_at)->isoFormat('HH:mm - DD.MM.YYYY') ?? '' }} --}}
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