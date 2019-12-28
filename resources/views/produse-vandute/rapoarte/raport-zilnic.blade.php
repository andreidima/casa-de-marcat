@extends ('layouts.app')

@section('content')   
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header justify-content-between" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-4 align-self-center">
                <h4 class=" mb-0">
                    <a href="/produse-vandute/rapoarte/raport-zilnic"><i class="fas fa-file-pdf"></i>Raport zilnic</a> / 
                    {{ \Carbon\Carbon::parse($search_data)->isoFormat('DD.MM.YYYY') ?? '' }}
                </h4>
            </div> 
            <div class="col-lg-4 align-self-center">
                {{-- <small class="badge badge-light"> --}}
                    Produse: <span class="badge badge-success"><h6 class="my-0">{{ $produse_vandute_nr }}</h6></span> / 
                    Suma: <span class="badge badge-success"><h6 class="my-0">{{ $produse_vandute_suma_totala }}</h6></span> lei
                {{-- </small> --}}
            </div> 
            <div class="col-lg-4 align-items-end" id="cautare_produse_vandute">
                <form class="needs-validation" novalidate method="GET" action="/produse-vandute/rapoarte/raport-zilnic/raport-html">
                    @csrf                    
                    <div class="flex-row-reverse input-group custom-search-form align-self-end">
                        <div class="col-md-8 d-flex m-0 p-0 justify-content-end">
                            <label for="search_data" class="mb-0 align-self-center mr-1">Data:</label>
                            <vue2-datepicker
                                data-veche="{{ $search_data }}"
                                nume-camp-db="search_data"
                                tip="date"
                                latime="100"
                            ></vue2-datepicker>
                            <button class="btn btn-sm btn-primary col-md-4 mx-1 border border-dark rounded-pill"
                                type="submit">
                                <i class="fas fa-search text-white"></i>Caută
                            </button>
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

            @if (session()->has('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded"> 
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>Nr. Crt.</th>
                            <th>Produs</th>
                            <th class="text-center">Preț</th>
                            <th class="text-center">Cantitatea</th>
                            <th class="text-center">Cod de bare</th>
                            <th class="text-right">Data vânzării</th>
                        </tr>
                    </thead>
                    <tbody>               
                        @forelse ($produse_vandute as $produs_vandut) 
                            <tr>                  
                                <td align="">
                                    {{ ($produse_vandute ->currentpage()-1) * $produse_vandute ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    {{-- <a class="" data-toggle="collapse" href="#collapse{{ $produs_vandut->id }}" role="button" 
                                        aria-expanded="false" aria-controls="collapse{{ $produs_vandut->id }}"> --}}
                                    <a href="{{ isset($produs_vandut->produs) ? $produs_vandut->produs->path() : ''}}">
                                        <b>{{ $produs_vandut->produs->nume ?? '' }}</b>
                                    </a>
                                </td>
                                <td class="text-right">
                                    {{ $produs_vandut->pret }} lei
                                </td>
                                <td class="text-center">
                                    {{ $produs_vandut->cantitate }}
                                </td>
                                <td class="text-center">
                                    {{ $produs_vandut->produs->cod_de_bare ?? '' }}
                                </td>
                                <td class="text-right">
                                    {{-- {{ \Carbon\Carbon::parse($produs_vandut->created_at)->isoFormat('D.MM.YYYY') ?? '' }} --}}
                                    {{ \Carbon\Carbon::parse($produs_vandut->created_at)->isoFormat('HH:MM - DD.MM.YYYY') ?? '' }}
                                    {{-- {{ $produs_vandut->created_at }} --}}
                                </td>
                            </tr>  
                            {{-- <tr class="collapse bg-white" id="collapse{{ $produs_vandut->id }}" 
                            >
                                <td colspan="6">
                                    <table class="table table-sm table-striped table-hover col-lg-6 mx-auto border"
                                    > 
                                        <tr>
                                            <td class="py-0">
                                                Nume
                                            </td>
                                            <td class="py-0">
                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-0">
                                                Nr. ord. reg. com.
                                            </td>
                                            <td class="py-0">
                                                
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr> 
                            <tr class="collapse">
                                <td colspan="6">

                                </td>                                       
                            </tr> --}}
                        @empty
                            <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div>
                        @endforelse
                        </tbody>
                </table>
            </div>

                <nav>
                    <ul class="pagination pagination-sm justify-content-center">
                        {{-- {{$produse_vandute->links()}} --}}
                        {{$produse_vandute->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>

    </div>
@endsection