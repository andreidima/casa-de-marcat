@extends ('layouts.app')

@section('content')   
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header justify-content-between py-1" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3 align-self-center">
                <h4 class=" mb-0">
                    {{-- <a href="{{ route('nir.index') }}">Nir</a> --}}
                    Nir - {{ \Carbon\Carbon::parse($search_data)->isoFormat('DD.MM.YYYY') }}
                </h4>
            </div> 
            <div class="col-lg-5" id="produse">
                <form class="needs-validation" novalidate method="GET" action="{{ route('nir.index') }}">
                    @csrf                    
                    <div class="row input-group custom-search-form justify-content-center align-self-end">
                        <div class="col-md-6">
                            <input type="text" class="form-control form-control-sm border rounded-pill mb-1 py-0" 
                            id="search_nume" name="search_nume" placeholder="Nume" autofocus
                                    value="{{ $search_nume }}">
                        </div>
                        <div class="col-md-6 d-flex mb-1">
                            <label for="search_data" class="mb-0 align-self-center mr-1">Data:</label>
                            <vue2-datepicker
                                data-veche="{{ $search_data }}"
                                nume-camp-db="search_data"
                                tip="date"
                                latime="100"
                            ></vue2-datepicker>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-sm btn-primary col-md-12 mr-1 border border-dark rounded-pill" type="submit">
                                <i class="fas fa-search text-white mr-1"></i>Caută
                            </button>
                        </div>
                        <div class="col-md-6">
                            <a class="btn btn-sm bg-secondary text-white col-md-12 border border-dark rounded-pill" href="{{ route('nir.index') }}" role="button">
                                <i class="fas fa-undo text-white mr-1"></i>Resetează căutarea
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-2 align-self-center text-right">
                <a href="nir/{{ $search_data }}/raport-pdf"
                    class="btn btn-sm btn-success mx-1 border border-dark rounded-pill"
                    target="_blank"
                >
                    <i class="fas fa-file-pdf mr-1"></i>Export PDF
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
                        @forelse ($produse_intrate->groupby('produs_id') as $produse_grupate_dupa_id)         
                            <tr>                  
                                <td align="">
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    <b>{{ ($produse_grupate_dupa_id->first()->nume) }}</b>
                                </td>
                                <td>
                                    buc
                                </td>
                                <td class="text-right">
                                    {{ $produse_grupate_dupa_id->sum('cantitate') - $produse_grupate_dupa_id->sum('cantitate_initiala')}}
                                </td>
                                <td class="text-right">
                                    {{ $produse_grupate_dupa_id->first()->pret_de_achizitie ? round(($produse_grupate_dupa_id->first()->pret_de_achizitie / 1.19), 2) : '' }}
                                </td>
                                <td class="text-right">
                                    {{ $produse_grupate_dupa_id->first()->pret_de_achizitie ? 
                                        (
                                            round(($produse_grupate_dupa_id->first()->pret_de_achizitie / 1.19), 2) 
                                            * 
                                            ($produse_grupate_dupa_id->sum('cantitate') - $produse_grupate_dupa_id->sum('cantitate_initiala'))
                                        ) : '' }}
                                </td>
                                <td class="text-right">
                                    {{ $produse_grupate_dupa_id->first()->pret_de_achizitie ? 
                                        (
                                            round(($produse_grupate_dupa_id->first()->pret_de_achizitie * 0.19), 2) 
                                            * 
                                            ($produse_grupate_dupa_id->sum('cantitate') - $produse_grupate_dupa_id->sum('cantitate_initiala'))
                                        ) : '' }}
                                </td>
                                <td class="text-right">
                                    {{ $produse_grupate_dupa_id->first()->pret }}
                                </td>
                                <td class="text-right">
                                    {{ $produse_grupate_dupa_id->first()->pret ? 
                                        (
                                            $produse_grupate_dupa_id->first()->pret 
                                            * 
                                            ($produse_grupate_dupa_id->sum('cantitate') - $produse_grupate_dupa_id->sum('cantitate_initiala'))
                                        ) : '' }}
                                </td>                             
                            </tr>  
                        @empty
                            <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div>
                        @endforelse
                            <tr>
                                <td colspan="5" class="text-right">
                                    Total
                                </td>
                                <td class="text-right">
                                    {{ round($produse_intrate->sum('total_suma_achizitie'), 2) }}                                    
                                </td>
                                <td class="text-right">
                                    {{ round($produse_intrate->sum('total_suma_tva'), 2) }}                                    
                                </td>
                                <td></td>
                                <td class="text-right">
                                    {{ round($produse_intrate->sum('total_suma_vanzare'), 2) }}                                    
                                </td>
                            </tr>
                        </tbody>
                </table>
            </div>


        </div>
    </div>
@endsection