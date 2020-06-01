@extends ('layouts.app')

@section('content')   
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header justify-content-between" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-6 p-0 align-self-center">
                <h5 class=" mb-0">
                    <a href="/rapoarte/miscari-stocuri"><i class="fas fa-people-carry mr-1"></i>Mișcări de stocuri</a> / 
                    {{ \Carbon\Carbon::parse($search_data_inceput)->isoFormat('DD.MM.YYYY') ?? '' }}
                    -
                    {{ \Carbon\Carbon::parse($search_data_sfarsit)->isoFormat('DD.MM.YYYY') ?? '' }}
                </h5>
            </div>  
            <div class="col-lg-6" id="cautare_produse_vandute">
                <form class="needs-validation" novalidate method="GET" action="{{ route('rapoarte.miscari_stocuri') }}">
                    @csrf                    
                    <div class="row input-group custom-search-form justify-content-center align-self-end">
                        <div class="col-md-12 d-flex mb-1 justify-content-center">
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
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-pill" href="{{ route('rapoarte.miscari_stocuri') }}" role="button">
                            <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-body">
            <div class="row d-flex">

            @include ('errors')

                <div class="col-lg-12 my-0 py-0">
                    <b>Legendă:</b>
                        <span class="badge badge-secondary mx-1" style="font-size: 1em">
                            Stoc vechi
                        </span>
                        <span class="badge badge-success mx-1" style="font-size: 1em">
                            Produs nou
                        </span>
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

            @foreach ($miscari_stocuri->groupby('categorie_id') as $categorie)
            {{-- @php
                dd($categorii_produse_vandute);
            @endphp --}}
                @foreach ($miscari_stocuri->where('categorie_id', $categorie->first()->categorie_id)->groupby('subcategorie_id') as $subcategorie)
                    <div class="card col-sm-12 my-4 shadow">
                        <div class="card-header mb-0">
                            <h4 class="mb-0">
                                {{ ($categorie->first()->categorie_nume) }} / {{ $subcategorie->first()->subcategorie_nume }}
                            </h4>
                        </div>
                        
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 mb-0 px-0 d-flex justify-content-center">
                                    <table class="table table-striped table-hover table-sm rounded mb-0" style="width: auto !important;
    table-layout: auto !important;">
                                @foreach ($miscari_stocuri->where('subcategorie_id', $subcategorie->first()->subcategorie_id)->groupby('produs_id') as $produs)
                                        <tr>    
                                    <td class="">
                                    {{ $loop->iteration }}. {{ $produs->first()->nume }}:
                                    </td>
                                    <td class="">
                                    @foreach ($miscari_stocuri->where('produs_id', $produs->first()->produs_id)->sortBy('created_at') as $cantitate)
                                        @if ($loop->first)
                                            @php
                                                $cantitate_initiala = App\ProdusCantitateIstoric::
                                                        where('produs_id' , $produs->first()->produs_id)
                                                    ->whereDate('created_at', '<', $search_data_inceput)
                                                    ->latest()
                                                    ->first();
                                            @endphp
                                            @isset($cantitate_initiala->cantitate)                                                
                                                <span class="badge badge-secondary" style="font-size: 1em">
                                                    {{ $cantitate_initiala->cantitate }}
                                                </span>
                                                @php
                                                    $cantitate_veche = $cantitate_initiala->cantitate
                                                @endphp
                                            @else                                             
                                                <span class="badge badge-success" style="font-size: 1em">
                                                    {{ $cantitate->cantitate }}
                                                </span>
                                                @php
                                                    $cantitate_veche = $cantitate->cantitate
                                                @endphp
                                            @endisset
                                        @endif
                                        @if($cantitate->operatiune == "modificare")
                                            <span class="badge badge-success" style="font-size: 1em">
                                                + {{ $cantitate->cantitate - $cantitate_veche }}
                                            </span>
                                        @elseif($cantitate->operatiune == "suplimentare stoc")
                                            <span class="badge badge-success" style="font-size: 1em">
                                                + {{ $cantitate->cantitate - $cantitate_veche }}
                                            </span>
                                        @elseif($cantitate->operatiune == "modificare stoc")
                                            <span class="badge badge-success" style="font-size: 1em">
                                                + {{ $cantitate->cantitate - $cantitate_veche }}
                                            </span>
                                        @elseif($cantitate->operatiune == "stergere stoc")
                                            <span class="badge badge-success" style="font-size: 1em">
                                                + {{ $cantitate->cantitate - $cantitate_veche }}
                                            </span>
                                        @elseif($cantitate->operatiune == "vanzare")
                                            <span class="badge badge-danger" style="font-size: 1em">
                                                - {{ $cantitate_veche - $cantitate->cantitate }}
                                            </span>
                                        @elseif($cantitate->operatiune == "vanzare stearsa")
                                            <span class="badge badge-warning" style="font-size: 1em">
                                                + {{ $cantitate->cantitate - $cantitate_veche }}
                                            </span>
                                        @endif                                        
                                        @php
                                            $cantitate_veche = $cantitate->cantitate
                                        @endphp
                                        @if ($loop->last)
                                            @isset($cantitate_initiala->cantitate)
                                                <span class="badge badge-primary" style="font-size: 1em">
                                                    = {{ $cantitate_veche }}
                                                </span>   
                                            @else 
                                                @if($loop->index > 0)
                                                    <span class="badge badge-primary" style="font-size: 1em">
                                                        = {{ $cantitate_veche }}
                                                    </span>   
                                                @endif
                                            @endif                                        
                                        @endif
                                    @endforeach
                                    </td>
                                        </tr>
                                @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
            </div>

        </div>

    </div>
@endsection