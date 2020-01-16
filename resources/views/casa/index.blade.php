@extends ('layouts.app')

@section('content')   
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header justify-content-between py-1" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-2 align-self-center">
                <h4 class=" mb-0">
                    <a href="{{ route('casa.index') }}"><i class="fas fa-wallet mr-1"></i>Casa</a>
                </h4>
            </div> 
            <div class="col-lg-10 align-self-center" id="cautare_produse_vandute">
                <form class="needs-validation" novalidate method="GET" action="{{ route('casa.index') }}">
                    @csrf                    
                    <div class="row input-group custom-search-form justify-content-end align-self-end">
                        <div class="col-md-5 d-flex">
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
                        <div class="col-md-3 px-1">
                            <button class="btn btn-sm btn-primary col-md-12 border border-dark rounded-pill" type="submit">
                                <i class="fas fa-search text-white mr-1"></i>Caută
                            </button>
                        </div>
                        <div class="col-md-3 px-1">
                            <a class="btn btn-sm bg-secondary text-white col-md-12 border border-dark rounded-pill" href="{{ route('casa.index') }}" role="button">
                                <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
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

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded"> 
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>Nr. Crt.</th>
                            <th>Operațiune</th>
                            <th>Detalii</th>
                            <th class="text-center">Suma</th>
                            <th class="text-center">Total Casă</th>
                            <th class="text-right">Data operațiunii</th>
                        </tr>
                    </thead>
                    <tbody>               
                        @forelse ($casa as $operatiune) 
                            <tr>                  
                                <td align="">
                                    {{ ($casa ->currentpage()-1) * $casa ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    {{ $operatiune->operatiune }}
                                </td>
                                <td>
                                    {{-- <a href="{{ isset($operatiune->produs) ? $operatiune->produs->path() : ''}}">
                                        <b>{{ $operatiune->produs->nume ?? '' }}</b>
                                    </a>
                                    @isset($operatiune->detalii)
                                     - {{ $operatiune->detalii }}
                                    @endisset --}}
                                    {{ $operatiune->produs_nume }}
                                </td>
                                <td class="text-right">
                                    {{ $operatiune->suma - $operatiune->suma_initiala }} lei
                                </td>
                                <td class="text-right">
                                    {{ $operatiune->suma }} lei
                                </td>
                                <td class="text-right">
                                    {{ \Carbon\Carbon::parse($operatiune->created_at)->isoFormat('HH:mm - DD.MM.YYYY') ?? '' }}
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
                        {{-- {{$casa->links()}} --}}
                        {{$casa->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection