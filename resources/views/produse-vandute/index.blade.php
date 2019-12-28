@extends ('layouts.app')

@section('content')   
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header justify-content-between py-1" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3 align-self-center">
                <h4 class=" mb-0"><a href="{{ route('produse-vandute.index') }}"><i class="fas fa-list-ul mr-1"></i>Produse vândute</a></h4>
            </div> 
            <div class="col-lg-6" id="cautare_produse_vandute">
                <form class="needs-validation" novalidate method="GET" action="{{ route('produse-vandute.index') }}">
                    @csrf                    
                    <div class="row input-group custom-search-form justify-content-center align-self-end">
                        <input type="text" class="form-control form-control-sm col-md-4 mr-1 border rounded-pill mb-1 py-0" 
                        id="search_cod_de_bare" name="search_cod_de_bare" placeholder="Cod de bare" autofocus
                                value="{{ $search_cod_de_bare }}">
                        <div class="col-md-8 d-flex mb-1">
                            <label for="search_date" class="mb-0 align-self-center mr-1">Interval:</label>
                            <vue2-datepicker
                                data-veche="{{ $search_data_inceput }}"
                                nume-camp-db="search_data_inceput"
                                tip="date"
                                latime="100"
                            ></vue2-datepicker>
                            <vue2-datepicker
                                data-veche="{{ $search_data_sfarsit }}"
                                nume-camp-db="search_data_sfarsit"
                                tip="date"
                                latime="150"
                            ></vue2-datepicker>
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
                                    {{ $produs_vandut->pret }}
                                </td>
                                <td class="text-center">
                                    {{ $produs_vandut->cantitate }}
                                </td>
                                <td class="text-center">
                                    {{ $produs_vandut->produs->cod_de_bare ?? '' }}
                                </td>
                                <td class="text-right">
                                    {{ \Carbon\Carbon::parse($produs_vandut->created_at)->isoFormat('HH:MM - DD.MM.YYYY') ?? '' }}
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