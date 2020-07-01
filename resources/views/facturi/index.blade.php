@extends ('layouts.app')

@section('content')   
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header justify-content-between py-1" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3 align-self-center">
                <h4 class=" mb-0">
                    <a href="{{ route('facturi.index') }}"><i class="fas fa-file-invoice mr-1"></i></i>Facturi</a>
                </h4>
            </div> 
            <div class="col-lg-6" id="">
                <form class="needs-validation" novalidate method="GET" action="{{ route('facturi.index') }}">
                    @csrf                    
                    <div class="row input-group custom-search-form justify-content-center">
                        <input type="text" class="form-control form-control-sm col-md-4 mr-1 border rounded-pill mb-1 py-0" 
                        id="search_firma" name="search_firma" placeholder="Firma" autofocus
                                value="{{ $search_firma }}">
                        <div class="col-md-4 px-1">
                            <button class="btn btn-sm btn-primary col-md-12 border border-dark rounded-pill" type="submit">
                                <i class="fas fa-search text-white mr-1"></i>Caută
                            </button>
                        </div>
                        <div class="col-md-4 px-1">
                            <a class="btn btn-sm bg-secondary text-white col-md-12 border border-dark rounded-pill" href="{{ route('facturi.index') }}" role="button">
                                <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 text-right">
                {{-- <a class="btn btn-sm bg-success text-white border border-dark rounded-pill col-md-8" href="{{ route('plati.create') }}" role="button">
                    <i class="fas fa-plus-square text-white mr-1"></i>Adaugă plată
                </a> --}}
            </div> 
        </div>

        <div class="card-body px-0 py-3">

            @include('errors')

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded"> 
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>Nr. Crt.</th>
                            <th>Factura</th>
                            <th>Firma</th>
                            <th>Produse</th>
                            <th class="text-center">Cantitate</th>
                            <th class="text-right">Valoare</th>
                            <th class="text-right">Data</th>
                            <th class="text-center">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>               
                        @forelse ($facturi as $factura) 
                            <tr>                  
                                <td align="">
                                    {{ ($facturi ->currentpage()-1) * $facturi ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    {{ $factura->seria }} {{ $factura->numar }}
                                </td>
                                <td>
                                    {{-- <a href="{{ $factura->path() }}"> --}}
                                        {{ $factura->firma ?? '' }}
                                    {{-- </a> --}}
                                </td>
                                <td class="">
                                    @foreach ($factura->produse as $produs)
                                        {{ $produs->nume }}
                                        <br>                                    
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    @foreach ($factura->produse as $produs)
                                        {{ $produs->cantitate }}
                                        <br>                                    
                                    @endforeach
                                </td>
                                <td class="text-right">
                                    @foreach ($factura->produse as $produs)
                                        {{ $produs->valoare }}
                                        <br>                                    
                                    @endforeach
                                </td>
                                <td class="text-right">
                                    {{ \Carbon\Carbon::parse($factura->created_at)->isoFormat('HH:mm - DD.MM.YYYY') ?? '' }}
                                </td>
                                <td class="text-right"> 
                                    {{-- <a href="{{ $plata->path() }}/modifica"
                                        class="flex"    
                                    >
                                        <span class="badge badge-primary">Modifică</span>
                                    </a>                                    --}}
                                    <a href="/produse/generare-factura-client/{{ $factura->id }}/export-pdf"
                                        {{-- class="btn btn-sm btn-success mx-1 border border-dark rounded-pill" --}}
                                    >
                                        <span class="badge badge-success">
                                            <i class="fas fa-file-pdf mr-1"></i>PDF
                                        </span>
                                    </a>                                    
                                    @if($factura->numar === \App\Factura::select('numar')->max('numar'))
                                        <div style="" class="">
                                            <a 
                                                href="#" 
                                                data-toggle="modal" 
                                                data-target="#stergeFactura{{ $factura->id }}"
                                                title="Șterge Factura"
                                                >
                                                <span class="badge badge-danger">Șterge</span>
                                            </a>
                                                <div class="modal fade text-dark" id="stergeFactura{{ $factura->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                            <h5 class="modal-title text-white" id="exampleModalLabel">Factura: <b>{{ $factura->seria }} {{ $factura->numar }}</b></h5>
                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="text-align:left;">
                                                            Ești sigur ca vrei să ștergi Factura?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                                            
                                                            <form method="POST" action="{{ $factura->path() }}">
                                                                @method('DELETE')  
                                                                @csrf   
                                                                <button 
                                                                    type="submit" 
                                                                    class="btn btn-danger"  
                                                                    >
                                                                    Șterge Factura
                                                                </button>                    
                                                            </form>
                                                        
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div> 
                                    @endif
                                </td>
                            </tr>  
                        @empty
                            <div>Nu s-au gasit facturi în baza de date. Încearcă alte date de căutare</div>
                        @endforelse
                        </tbody>
                </table>
            </div>

                <nav>
                    <ul class="pagination pagination-sm justify-content-center">
                        {{$facturi->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection