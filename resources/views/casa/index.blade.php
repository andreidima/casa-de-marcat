@extends ('layouts.app')

@section('content')   
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header justify-content-between py-1" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-2 align-self-center">
                <h4 class=" mb-0">
                    <a href="{{ route('casa.index') }}"><i class="fas fa-wallet mr-1"></i>Casa</a>
                </h4>
            </div> 
            {{-- <div class="col-lg-10 align-self-center" id="cautare_produse_vandute">
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
            </div> --}}
            <div class="col-lg-3 text-right">
                <a class="btn btn-sm btn-primary border border-dark rounded-pill col-md-8" href="{{ route('casa.create') }}" role="button">
                    <i class="fas fa-cog mr-1"></i>Setează suma
                </a>
            </div> 
        </div>
        
        <div class="row card-header py-4">
                <div class="col-12 mt-2 mb-0">
                    <h5 class="">                          
                        <span class="badge badge-dark"
                        >
                            Suma inițială = 
                            <span class="badge text-white m-0" style="background-color:#e66800; font-size: 1em;">
                                    {{ $casa->first()->suma ?? 0 }}
                            </span>
                            lei
                        </span>        
                        +                   
                        <span class="badge badge-dark"
                        >
                            Vanzări = 
                            <span class="badge text-white m-0" style="background-color:#e66800; font-size: 1em;">
                                    {{ $suma['produse_vandute'] }}
                            </span>
                            lei
                        </span>
                        +              
                        <span class="badge badge-dark"
                        >
                            Avansuri = 
                            <span class="badge text-white m-0" style="background-color:#e66800; font-size: 1em;">
                                    {{ $suma['avansuri'] }}
                            </span>
                            lei
                        </span>
                        -          
                        <span class="badge badge-dark"
                        >
                            Plăți = 
                            <span class="badge text-white m-0" style="background-color:#e66800; font-size: 1em;">
                                    {{ $suma['plati'] }}
                            </span>
                            lei
                        </span>
                        =    
                        <span class="badge badge-dark"
                        >         
                            <span class="badge text-white m-0" style="background-color:#e66800; font-size: 1em;">
                                    {{ $suma['suma_totala'] }}
                            </span>        
                            lei   
                        </span>
                    </h5>
                </div>
        </div>

        <div class="card-body px-0 py-4 my-2">
            
            @include ('errors')

            <div class="table-responsive rounded col-12 d-flex justify-content-center">
                <table class="table table-striped table-hover table-sm rounded col-8"> 
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>Nr. Crt.</th>
                            <th class="text-center">Suma</th>
                            <th class="text-right">Data setării</th>
                            <th class="text-center">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>               
                        @forelse ($casa as $inregistrare) 
                            <tr>                  
                                <td align="">
                                    {{ ($casa ->currentpage()-1) * $casa ->perpage() + $loop->index + 1 }}
                                </td>
                                <td class="text-right">
                                    {{ $inregistrare->suma }} lei
                                </td>
                                <td class="text-right">
                                    {{ \Carbon\Carbon::parse($inregistrare->created_at)->isoFormat('HH:mm - DD.MM.YYYY') ?? '' }}
                                </td>
                                <td class="d-flex justify-content-end"> 
                                    <a href="{{ $inregistrare->path() }}/modifica"
                                        class="flex"    
                                    >
                                        <span class="badge badge-primary">Modifică</span>
                                    </a>                                   
                                    <div style="flex" class="">
                                        <a 
                                            {{-- class="btn btn-danger btn-sm"  --}}
                                            href="#" 
                                            {{-- role="button" --}}
                                            data-toggle="modal" 
                                            data-target="#stergeSetare{{ $inregistrare->id }}"
                                            title="Șterge Setare"
                                            >
                                            {{-- <i class="far fa-trash-alt"></i> --}}
                                            <span class="badge badge-danger">Șterge</span>
                                        </a>
                                            <div class="modal fade text-dark" id="stergeSetare{{ $inregistrare->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title text-white" id="exampleModalLabel">Setare: <b>{{ $inregistrare->suma }} lei</b></h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" style="text-align:left;">
                                                        Ești sigur ca vrei să ștergi Setarea?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                                        
                                                        <form method="POST" action="{{ $inregistrare->path() }}">
                                                            @method('DELETE')  
                                                            @csrf   
                                                            <button 
                                                                type="submit" 
                                                                class="btn btn-danger"  
                                                                >
                                                                Șterge Setare
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
                            {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
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