@extends ('layouts.app')

@section('content')   
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header justify-content-between py-1" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3 align-self-center">
                <h4 class=" mb-0">
                    <a href="{{ route('niruri.index') }}"><i class="fas fa-money-bill-wave mr-1"></i></i>Niruri</a>
                </h4>
            </div> 
            <div class="col-lg-6" id="">
                <form class="needs-validation" novalidate method="GET" action="{{ route('niruri.index') }}">
                    @csrf                    
                    <div class="row input-group custom-search-form justify-content-center">
                        <input type="text" class="form-control form-control-sm col-md-4 mr-1 border rounded-pill mb-1 py-0" 
                        id="search_nir" name="search_nir" placeholder="Nir" autofocus
                                value="{{ $search_nir }}">
                        <div class="col-md-4 px-1">
                            <button class="btn btn-sm btn-primary col-md-12 border border-dark rounded-pill" type="submit">
                                <i class="fas fa-search text-white mr-1"></i>Caută
                            </button>
                        </div>
                        <div class="col-md-4 px-1">
                            <a class="btn btn-sm bg-secondary text-white col-md-12 border border-dark rounded-pill" href="{{ route('niruri.index') }}" role="button">
                                <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @include ('errors')

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded"> 
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>Nr.</th>
                            <th>Nir</th>
                            <th class="">Produs</th>
                            <th class="">Furnizor</th>
                            <th class="">Factura</th>
                            <th class="">Cantitate</th>                            
                            <th class="">Preț de achiziție</th>
                            <th class="">Data</th>
                            <th class="text-center">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>               
                        @forelse ($niruri as $nir) 
                            <tr>                  
                                <td align="">
                                    {{ ($niruri ->currentpage()-1) * $niruri ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    {{-- <a href="{{ $nir->path() }}"> --}}
                                        {{ $nir->nir }}
                                    {{-- </a> --}}
                                </td>
                                <td>
                                    {{ $nir->produs_stoc->produs->nume ?? '' }}
                                </td>
                                <td>
                                    {{ $nir->produs_stoc->furnizor->nume ?? '' }}
                                </td>
                                <td>
                                    {{ $nir->produs_stoc->nr_factura ?? '' }}
                                </td>
                                <td>
                                    {{ $nir->produs_stoc->cantitate ?? '' }}
                                </td>
                                <td>
                                    {{ $nir->produs_stoc->pret_de_achizitie ?? '' }}
                                </td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($nir->created_at)->isoFormat('DD.MM.YYYY') ?? '' }}
                                </td>
                                <td class="d-flex justify-content-end"> 
                                    {{-- <a href="{{ $plata->path() }}/modifica"
                                        class="flex"    
                                    >
                                        <span class="badge badge-primary">Modifică</span>
                                    </a>                                    --}}
                                    <div style="flex" class="">
                                        <a 
                                            href="#" 
                                            data-toggle="modal" 
                                            data-target="#stergeNir{{ $nir->id }}"
                                            title="Șterge Nir"
                                            >
                                            <span class="badge badge-danger">Șterge</span>
                                        </a>
                                            <div class="modal fade text-dark" id="stergeNir{{ $nir->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title text-white" id="exampleModalLabel">Nir: <b>{{ $nir->nir }}</b></h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" style="text-align:left;">
                                                        Ești sigur ca vrei să ștergi Nirul?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                                        
                                                        <form method="POST" action="{{ $nir->path() }}">
                                                            @method('DELETE')  
                                                            @csrf   
                                                            <button 
                                                                type="submit" 
                                                                class="btn btn-danger"  
                                                                >
                                                                Șterge Nir
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
                        @endforelse
                        </tbody>
                </table>
            </div>

                <nav>
                    <ul class="pagination pagination-sm justify-content-center">
                        {{$niruri->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection