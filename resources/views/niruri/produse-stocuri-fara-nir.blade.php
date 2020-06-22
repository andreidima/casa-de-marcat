@extends ('layouts.app')

@section('content')   
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header justify-content-between py-1" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3 align-self-center">
                <h4 class=" mb-0">
                    {{-- <a href="{{ route('nir.index') }}">Nir</a> --}}
                    Produse fără nir generat
                </h4>
            </div> 
            <div class="col-lg-7" id="produse">
                {{-- <form class="needs-validation" novalidate method="GET" action="{{ route('nir.index') }}">
                    @csrf                    
                    <div class="row input-group custom-search-form justify-content-center align-self-end">
                        <div class="col-md-6">
                            <input type="text" class="form-control form-control-sm border rounded-pill mb-1 py-0" 
                            id="search_nume" name="search_nume" placeholder="Nume" autofocus
                                    value="{{ $search_nume }}">
                        </div>
                        <div class="col-md-4 d-flex mb-0 align-self-center">
                            <label for="search_data" class="mb-0 align-self-center mr-1">Data:</label>
                            <vue2-datepicker
                                data-veche="{{ $search_data }}"
                                nume-camp-db="search_data"
                                tip="date"
                                latime="100"
                            ></vue2-datepicker>
                        </div>
                        <div class="col-md-4 mb-0 align-self-center">
                            <button class="btn btn-sm btn-primary col-md-12 border border-dark rounded-pill" type="submit">
                                <i class="fas fa-search text-white mr-1"></i>Caută
                            </button>
                        </div>
                        <div class="col-md-4 mb-0 align-self-center">
                            <a class="btn btn-sm bg-secondary text-white col-md-12 border border-dark rounded-pill" href="{{ route('nir.index') }}" role="button">
                                <i class="fas fa-undo text-white mr-1"></i>Resetează căutarea
                            </a>
                        </div>
                    </div>
                </form> --}}
            </div>
            <div class="col-lg-2 align-middle">
                {{-- <a href="nir/{{ $search_data }}/raport-pdf"
                    class="btn btn-sm btn-success mx-1 border border-dark rounded-pill"
                    target="_blank"
                >
                    <i class="fas fa-file-pdf mr-1"></i>Export PDF
                </a> --}}         

                @if(count($produse_stocuri_telefoane_noi) || count($produse_stocuri_accesorii))
                    <a href="/niruri/genereaza-nir">
                        <h4 class="mb-0"><span class="badge badge-primary">Generează Nirurile</span></h4>
                    </a>
                @endif
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @include ('errors')

            {{-- Telefoane noi --}}
            @forelse ($produse_stocuri_telefoane_noi->groupBy(function ($data) {
                    return \Carbon\Carbon::parse($data->created_at)->format('Y-m-d');
                }) as $produse_per_data)
            @forelse ($produse_per_data->groupBy('furnizor_id') as $produse_per_furnizor)
            @forelse ($produse_per_furnizor->groupBy('nr_factura') as $produse_per_factura)

                @php
                    $total_suma_achizitie = 0;
                    $total_suma_tva = 0;
                    $total_suma_vanzare = 0;
                @endphp
            
                <div class="table-responsive rounded mb-5">
                    <table class="table table-striped table-hover table-sm rounded"> 
                        <thead class="text-white rounded" style="background-color:#e66800;">
                            <tr>
                                <th colspan="9" class="py-0 border-0 text-center bg-secondary">
                                    Furnizor: {{ $produse_per_factura->first()->furnizor->nume ?? 'nu este specificat' }}
                                    |
                                    Factură: {{ $produse_per_factura->first()->nr_factura ?? 'nu este specificată'}}
                                    |
                                    Data: {{ $produse_per_factura->first()->created_at }}
                                </th>
                            </tr>
                            <tr class="" style="padding:2rem">
                                <th>Nr. Crt.</th>
                                <th class="">Produs</th>
                                <th class="text-center">U/M</th>
                                <th class="text-center">Cantitatea</th>
                                <th class="text-center">Pret achizitie</th>
                                <th class="text-center">Valoare</th>
                                <th class="text-center">TVA</th>
                                {{-- <th class="text-center">Pret Vanzare</th>
                                <th class="text-center">Total</th> --}}
                            </tr>
                        </thead>
                        <tbody>      
                            @forelse ($produse_per_factura as $produs_stoc)
                                <tr>                  
                                    <td align="">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <b>{{ $produs_stoc->produs->nume ?? '' }}</b>
                                    </td>
                                    <td>
                                        buc
                                    </td>
                                    <td class="text-right">
                                        {{ $produs_stoc->cantitate }}
                                    </td>
                                    <td class="text-right">
                                        {{-- {{ $produs_stoc->pret_de_achizitie ? number_format(round(($produs_stoc->pret_de_achizitie / 1.19), 2) , 2) : '' }} --}}
                                        {{ $produs_stoc->pret_de_achizitie }}
                                    </td>
                                    <td class="text-right">
                                        @isset($produs_stoc->pret_de_achizitie)
                                            {{-- {{ number_format(round(($produs_stoc->pret_de_achizitie / 1.19), 2) * $produs_stoc->cantitate , 2) }} 
                                            @php 
                                                $total_suma_achizitie += round(($produs_stoc->pret_de_achizitie / 1.19), 2) * $produs_stoc->cantitate
                                            @endphp --}}
                                            {{ number_format($produs_stoc->pret_de_achizitie * $produs_stoc->cantitate , 2) }} 
                                            @php 
                                                $total_suma_achizitie += $produs_stoc->pret_de_achizitie * $produs_stoc->cantitate
                                            @endphp
                                        @endisset
                                    </td>
                                    <td class="text-right">
                                        @isset($produs_stoc->pret_de_achizitie)
                                            {{ number_format(round_up((($produs_stoc->pret_de_achizitie * 0.19) * $produs_stoc->cantitate), 2) , 2) }} 
                                            @php 
                                                $total_suma_tva += round_up((($produs_stoc->pret_de_achizitie * 0.19) * $produs_stoc->cantitate), 2)
                                            @endphp
                                            {{-- {{ number_format($produs_stoc->pret_de_achizitie * $produs_stoc->cantitate , 2) }} 
                                            @php 
                                                $total_suma_tva += $produs_stoc->pret_de_achizitie * $produs_stoc->cantitate
                                            @endphp --}}
                                        @endisset
                                    </td>
                                    {{-- <td class="text-right">
                                        {{ $produs_stoc->produs->pret ?? '' }}
                                    </td>
                                    <td class="text-right">
                                        @isset($produs_stoc->produs->pret)
                                            {{ $produs_stoc->produs->pret * $produs_stoc->cantitate }} 
                                            @php 
                                                $total_suma_vanzare += $produs_stoc->produs->pret * $produs_stoc->cantitate
                                            @endphp
                                        @endisset
                                    </td>                              --}}
                                </tr>  
                            @empty
                            @endforelse
                                <tr>
                                    <td colspan="5" class="text-right">
                                        Total
                                    </td>
                                    <td class="text-right">
                                        {{ $total_suma_achizitie }}
                                    </td>
                                    <td class="text-right">
                                        {{ $total_suma_tva }}
                                    </td>
                                    {{-- <td></td>
                                    <td class="text-right">
                                        {{ $total_suma_vanzare }}
                                    </td> --}}
                                </tr>
                            </tbody>
                    </table>
                </div>
                
                <form class="needs-validation" novalidate method="GET" action="{{ route('nir.genereaza-nir-singular') }}">
                    @csrf                    
                    <div class="row input-group custom-search-form justify-content-center align-self-end">
                        <div class="col-md-12 d-flex mb-1 justify-content-center">
                            <label for="data_nir" class="mb-0 align-self-center mr-1">Setare data nir:</label>
                            <vue2-datepicker
                                data-veche="{{ $data_nir }}"
                                nume-camp-db="data_nir"
                                tip="date"
                                latime="100"
                            ></vue2-datepicker>
                        </div>
                        <button class="btn btn-sm btn-primary col-md-4 mr-1 border border-dark rounded-pill" type="submit">
                            Generează Nir
                        </button>
                    </div>
                </form>
            @empty
            @endforelse
            @empty
            @endforelse
            @empty
            @endforelse

            {{-- Accesorii --}}
            @forelse ($produse_stocuri_accesorii->groupBy(function ($data) {
                    return \Carbon\Carbon::parse($data->created_at)->format('Y-m-d');
                }) as $produse_per_data)
            @forelse ($produse_per_data->groupBy('furnizor_id') as $produse_per_furnizor)
            @forelse ($produse_per_furnizor->groupBy('nr_factura') as $produse_per_factura)

                @php
                    $total_suma_achizitie = 0;
                    $total_suma_tva = 0;
                    $total_suma_vanzare = 0;
                @endphp
            
                <div class="table-responsive rounded mb-5">
                    <table class="table table-striped table-hover table-sm rounded"> 
                        <thead class="text-white rounded" style="background-color:#e66800;">
                            <tr>
                                <th colspan="9" class="py-0 border-0 text-center bg-secondary">
                                    Furnizor: {{ $produse_per_factura->first()->furnizor->nume ?? 'nu este specificat' }}
                                    |
                                    Factură: {{ $produse_per_factura->first()->nr_factura ?? 'nu este specificată'}}
                                    |
                                    Data: {{ \Carbon\Carbon::parse($produse_per_factura->first()->created_at)->isoFormat('D.MM.YYYY') }}
                                </th>
                            </tr>
                            <tr class="" style="padding:2rem">
                                <th>Nr. Crt.</th>
                                <th class="">Produs</th>
                                <th class="text-center">U/M</th>
                                <th class="text-center">Cantitatea</th>
                                <th class="text-center">Pret achizitie</th>
                                <th class="text-center">Valoare</th>
                                <th class="text-center">TVA</th>
                                <th class="text-center">Pret Vanzare</th>
                                <th class="text-center">Total</th>
                            </tr>
                        </thead>
                        <tbody>      
                            @forelse ($produse_per_factura as $produs_stoc)
                                <tr>                  
                                    <td align="">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <b>{{ $produs_stoc->produs->nume ?? '' }}</b>
                                    </td>
                                    <td>
                                        buc
                                    </td>
                                    <td class="text-right">
                                        {{ $produs_stoc->cantitate }}
                                    </td>
                                    <td class="text-right">
                                        {{-- {{ $produs_stoc->pret_de_achizitie ? number_format(round(($produs_stoc->pret_de_achizitie / 1.19), 2) , 2) : '' }} --}}
                                        {{ $produs_stoc->pret_de_achizitie }}
                                    </td>
                                    <td class="text-right">
                                        @isset($produs_stoc->pret_de_achizitie)
                                            {{-- {{ number_format(round(($produs_stoc->pret_de_achizitie / 1.19), 2) * $produs_stoc->cantitate , 2) }} 
                                            @php 
                                                $total_suma_achizitie += round(($produs_stoc->pret_de_achizitie / 1.19), 2) * $produs_stoc->cantitate
                                            @endphp --}}
                                            {{ number_format($produs_stoc->pret_de_achizitie * $produs_stoc->cantitate , 2) }} 
                                            @php 
                                                $total_suma_achizitie += $produs_stoc->pret_de_achizitie * $produs_stoc->cantitate
                                            @endphp
                                        @endisset
                                    </td>
                                    <td class="text-right">
                                        @isset($produs_stoc->pret_de_achizitie)
                                            {{ number_format(round_up((($produs_stoc->pret_de_achizitie * 0.19) * $produs_stoc->cantitate), 2) , 2) }} 
                                            @php 
                                                $total_suma_tva += round_up((($produs_stoc->pret_de_achizitie * 0.19) * $produs_stoc->cantitate), 2)
                                            @endphp
                                            {{-- {{ number_format($produs_stoc->pret_de_achizitie * $produs_stoc->cantitate , 2) }} 
                                            @php 
                                                $total_suma_tva += $produs_stoc->pret_de_achizitie * $produs_stoc->cantitate
                                            @endphp --}}
                                        @endisset
                                    </td>
                                    <td class="text-right">
                                        {{ $produs_stoc->produs->pret ?? '' }}
                                    </td>
                                    <td class="text-right">
                                        @isset($produs_stoc->produs->pret)
                                            {{ $produs_stoc->produs->pret * $produs_stoc->cantitate }} 
                                            @php 
                                                $total_suma_vanzare += $produs_stoc->produs->pret * $produs_stoc->cantitate
                                            @endphp
                                        @endisset
                                    </td>                             
                                </tr>  
                            @empty
                            @endforelse
                                <tr>
                                    <td colspan="5" class="text-right">
                                        Total
                                    </td>
                                    <td class="text-right">
                                        {{ $total_suma_achizitie }}
                                    </td>
                                    <td class="text-right">
                                        {{ $total_suma_tva }}
                                    </td>
                                    <td></td>
                                    <td class="text-right">
                                        {{ $total_suma_vanzare }}
                                    </td>
                                </tr>
                            </tbody>
                    </table>
                </div>
                
                <div id="cautare_produse_vandute">
                    <form class="needs-validation" novalidate method="GET" 
                        action="{{ route('nir.genereaza-nir-singular', 
                            [
                                'furnizor_id' => $produse_per_factura->first()->furnizor->id,
                                'nr_factura' => $produse_per_factura->first()->nr_factura
                            ]
                        ) }}">
                        
                        @csrf                    
                        <div class="row input-group custom-search-form justify-content-center align-self-end">
                            <div class="col-md-12 d-flex mb-1 justify-content-center">
                                <label for="data_nir" class="mb-0 align-self-center mr-1">Setare data nir:</label>
                                <vue2-datepicker
                                    data-veche="{{ $data_nir ?? \Carbon\Carbon::now() }}"
                                    nume-camp-db="data_nir"
                                    tip="date"
                                    latime="100"
                                ></vue2-datepicker>
                            </div>
                            <button class="btn btn-sm btn-primary col-md-4 mr-1 border border-dark rounded-pill" type="submit">
                                Generează Nir
                            </button>
                        </div>
                    </form>
                </div>
            @empty
            @endforelse
            @empty
            @endforelse  
            @empty
            @endforelse          

            @if(!count($produse_stocuri_telefoane_noi) && !count($produse_stocuri_accesorii))
                <div class="p-4">
                    <h5>Lista este goala. Toate produsele sunt atasate la niruri.</h5>
                </div>
            @endif

        </div>
    </div>
@endsection