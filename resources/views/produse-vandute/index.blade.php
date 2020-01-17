@extends ('layouts.app')

@section('content')   
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header justify-content-between py-1" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3 align-self-center">
                <h4 class=" mb-0">
                    <a href="{{ route('produse-vandute.index') }}"><i class="fas fa-list-ul mr-1"></i>Produse vândute</a>
                </h4>
            </div> 
            <div class="col-lg-8" id="cautare_produse_vandute">
                <form class="needs-validation" novalidate method="GET" action="{{ route('produse-vandute.index') }}">
                    @csrf                    
                    <div class="row input-group custom-search-form justify-content-center align-self-end">
                        <div class="col-md-3">
                            <input type="text" class="form-control form-control-sm border rounded-pill mb-1 py-0" 
                            id="search_cod_de_bare" name="search_cod_de_bare" placeholder="Cod de bare" autofocus
                                    value="{{ $search_cod_de_bare }}">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control form-control-sm border rounded-pill mb-1 py-0" 
                            id="search_detalii" name="search_detalii" placeholder="Detalii" autofocus
                                    value="{{ $search_detalii }}">
                        </div>
                        <div class="col-md-6 d-flex mb-1">
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
                            <th class="w-50">Produs</th>
                            <th class="text-center">Cantitatea</th>
                            <th class="text-center">Preț raft</th>
                            <th class="text-center">Preț vânzare</th>
                            {{-- <th class="text-center">Cod de bare</th> --}}
                            <th class="text-right">Data vânzării</th>
                            <th class="text-center">Acțiuni</th>
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
                                    @isset($produs_vandut->detalii)
                                     - {{ $produs_vandut->detalii }}
                                    @endisset
                                </td>
                                <td class="text-center">
                                    {{ $produs_vandut->cantitate }}
                                </td>
                                <td class="text-right">
                                    {{ $produs_vandut->produs->pret }} lei
                                </td>
                                <td class="text-right">
                                    {{ $produs_vandut->pret }} lei
                                </td>
                                <td class="text-right">
                                    {{ \Carbon\Carbon::parse($produs_vandut->created_at)->isoFormat('HH:mm - DD.MM.YYYY') ?? '' }}
                                </td>
                                <td class="d-flex justify-content-end">      
                                    <div style="flex" class="">
                                        <a 
                                            href="#" 
                                            data-toggle="modal" 
                                            data-target="#stergeProdusVandut{{ $produs_vandut->id }}"
                                            title="Șterge Produs Vândut"
                                            >
                                            <span class="badge badge-danger">Șterge</span>
                                        </a>
                                            <div class="modal fade text-dark" id="stergeProdusVandut{{ $produs_vandut->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title text-white" id="exampleModalLabel">
                                                            Produs Vândut: <b>{{ $produs_vandut->produs->nume }}</b>
                                                            @isset($produs_vandut->detalii)
                                                                - {{ $produs_vandut->detalii }}
                                                            @endisset
                                                        </h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" style="text-align:left;">
                                                        Ești sigur ca vrei să ștergi vânzarea?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                                        
                                                        <form method="POST" action="{{ $produs_vandut->path() }}">
                                                            @method('DELETE')  
                                                            @csrf   
                                                            <button 
                                                                type="submit" 
                                                                class="btn btn-danger"  
                                                                >
                                                                Șterge Vânzarea
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
                        {{-- {{$produse_vandute->links()}} --}}
                        {{$produse_vandute->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection