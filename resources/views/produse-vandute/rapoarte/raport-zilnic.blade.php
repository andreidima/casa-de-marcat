@extends ('layouts.app')

@section('content')   
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header justify-content-between" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3 p-0 align-self-center">
                <h5 class=" mb-0">
                    <a href="/produse-vandute/rapoarte/raport-zilnic"><i class="fas fa-file-pdf mr-1"></i>Raport zilnic</a> / 
                    {{ \Carbon\Carbon::parse($search_data)->isoFormat('DD.MM.YYYY') ?? '' }}
                </h5>
            </div> 
            <div class="col-lg-5 p-0 align-self-center text-center">
                    {{-- Produse: 
                    <span class="badge badge-success" style="background-color:#e66800;">
                        <h6 class="my-0">
                            {{ $produse_vandute->sum('cantitate') + $avansuri->count() }}
                        </h6>
                    </span>
                    / Suma: 
                    <span class="badge badge-success" style="background-color:#e66800;">
                        <h6 class="my-0">
                            {{ $produse_vandute->sum('total_vandut') + $avansuri->sum('suma') }} lei
                        </h6>
                    </span> --}}
                {{-- <a href="/produse-vandute/rapoarte/raport-zilnic/{{ \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') }}/export/raport-pdf"
                    class="btn btn-sm btn-success mx-1 border border-dark rounded-pill"
                >
                    <i class="fas fa-file-pdf mr-1"></i>Export PDF
                </a> --}}
            </div> 
            <div class="col-lg-3 p-0 align-items-end" id="cautare_produse_vandute">
                <form class="needs-validation" novalidate method="GET" action="/produse-vandute/rapoarte/raport-zilnic/raport-html">
                    @csrf                    
                    <div class="flex-row-reverse input-group custom-search-form align-self-end">
                        <div class="col-md-12 d-flex m-0 p-0 justify-content-end">
                            <label for="search_data" class="mb-0 align-self-center mr-1">Data:</label>
                            <vue2-datepicker
                                data-veche="{{ $search_data }}"
                                nume-camp-db="search_data"
                                tip="date"
                                latime="100"
                            ></vue2-datepicker>
                            <button class="btn btn-sm btn-primary col-md-4 mx-1 border border-dark rounded-pill"
                                type="submit">
                                <i class="fas fa-search text-white mr-1"></i>Caută
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-body">

            @include ('errors')
            {{-- @php
                dd($produse_vandute);
            @endphp --}}
{{-- {{$produse_vandute->count()}} --}}
            @foreach ($produse_vandute->groupby('categorie_id') as $categorii_produse_vandute)
            {{-- @php
                dd($categorii_produse_vandute);
            @endphp --}}
                <div class="row justify-content-center">
                    <div class="col-sm-10 m-4 p-4 border d-flex" style="border-left: 5px solid darkcyan !important;">
                        <div class="col-5">
                            <h5 class="" style="display:inline">{{ ($categorii_produse_vandute->first()->categorie_nume) }}</h5>
                        </div>
                        <div class="col-4">
                            Produse: 
                            <span class="badge badge-success" style="background-color:#e66800;">
                                <h6 class="my-0">{{ $categorii_produse_vandute->sum('cantitate') }}</h6>
                            </span>
                            / 
                            Suma: 
                            <span class="badge badge-success" style="background-color:#e66800;">
                                <h6 class="my-0">{{ $categorii_produse_vandute->sum('total_vandut') }} lei</h6>
                            </span>
                        </div>
                        <div class="col-3 text-right">
                            <a href="/produse-vandute/rapoarte/raport-zilnic/{{ \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') }}/{{ $categorii_produse_vandute->first()->categorie_id }}/export/raport-pdf"
                                class="btn btn-sm btn-success mx-1 border border-dark rounded-pill"
                            >
                                <i class="fas fa-file-pdf mr-1"></i>Export PDF
                            </a>
                        </div>
                    </div>
                </div>
                
                {{-- {{ ($categorii_produse_vandute->first()->categorie_nume) }}
                <br>
                {{ $categorii_produse_vandute->sum('cantitate') }}
                <br>
                {{ $categorii_produse_vandute->sum('total') }}
                <br> --}}
                {{-- @foreach ($categorii_produse_vandute as $produse_vandute)
                    {{ $loop->iteration }}{{ $produse_vandute->nume }}
                    <br>
                @endforeach --}}
            @endforeach

                <div class="row justify-content-center">
                    <div class="col-sm-10 m-4 p-4 border d-flex" style="border-left: 5px solid darkcyan !important;">
                        <div class="col-5">
                            <h5 class="" style="display:inline">Avansuri</h5>
                        </div>
                        <div class="col-4">
                            Avansuri: 
                            <span class="badge badge-success" style="background-color:#e66800;">
                                <h6 class="my-0">{{ $avansuri->count() }}</h6>
                            </span>
                            / 
                            Suma: 
                            <span class="badge badge-success" style="background-color:#e66800;">
                                <h6 class="my-0">{{ $avansuri->sum('suma') }} lei</h6>
                            </span>
                        </div>
                        <div class="col-3 text-right">
                            <a href="/produse-vandute/rapoarte/raport-zilnic/{{ \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') }}/avansuri/export/raport-pdf"
                                class="btn btn-sm btn-success mx-1 border border-dark rounded-pill"
                            >
                                <i class="fas fa-file-pdf mr-1"></i>Export PDF
                            </a>
                        </div>
                    </div>
                </div>


                <div class="row justify-content-center">
                    <div class="col-sm-10 m-4 p-4 border d-flex" style="border-left: 5px solid darkcyan !important;">
                        <div class="col-5">
                            <h5 class="" style="display:inline">Plăți</h5>
                        </div>
                        <div class="col-4">
                            Plăți: 
                            <span class="badge badge-success" style="background-color:#e66800;">
                                <h6 class="my-0">{{ $plati->count() }}</h6>
                            </span>
                            / 
                            Suma: 
                            <span class="badge badge-success" style="background-color:#e66800;">
                                <h6 class="my-0">{{ $plati->sum('suma') }} lei</h6>
                            </span>
                        </div>
                        <div class="col-3 text-right">
                            <a href="/produse-vandute/rapoarte/raport-zilnic/{{ \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') }}/plati/export/raport-pdf"
                                class="btn btn-sm btn-success mx-1 border border-dark rounded-pill"
                            >
                                <i class="fas fa-file-pdf mr-1"></i>Export PDF
                            </a>
                        </div>
                    </div>
                </div>
            {{-- <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded"> 
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>Nr. Crt.</th>
                            <th>Produs</th>
                            <th class="text-center">Cantitatea</th>
                            <th class="text-center">Preț raft</th>
                            <th class="text-center">Preț vânzare</th>
                            <th class="text-right">Data vânzării</th>
                        </tr>
                    </thead>
                    <tbody>               
                        @forelse ($produse_vandute as $produs_vandut) 
                            <tr>                  
                                <td align="">
                                    {{ ($produse_vandute ->currentpage()-1) * $produse_vandute ->perpage() + $loop->index + 1 }}
                                </td>
                                <td style="width:30%">
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
                                    {{ $produs_vandut->produs->pret ?? ''}} lei
                                </td>
                                <td class="text-right">
                                    {{ $produs_vandut->pret }} lei
                                </td>
                                <td class="text-right">
                                    {{ \Carbon\Carbon::parse($produs_vandut->created_at)->isoFormat('HH:mm - DD.MM.YYYY') ?? '' }}
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
                        {{$produse_vandute->appends(Request::except('page'))->links()}}
                    </ul>
                </nav> --}}

        </div>

    </div>
@endsection