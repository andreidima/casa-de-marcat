@extends ('layouts.app')

@section('content')   
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header justify-content-between py-1" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3 align-self-center">
                <h4 class=" mb-0">
                    <a href="{{ route('stocuri.index') }}"><i class="fas fa-boxes mr-1"></i></i>Stocuri</a>
                </h4>
            </div> 
            <div class="col-lg-6" id="">
                <form class="needs-validation" novalidate method="GET" action="{{ route('stocuri.index') }}">
                    @csrf                    
                    <div class="row input-group custom-search-form justify-content-center">
                        <input type="text" class="form-control form-control-sm col-md-4 mr-1 border rounded-pill mb-1 py-0" 
                            id="search_produs" name="search_produs" placeholder="Produs" autofocus
                                value="{{ $search_produs }}">
                        <input type="text" class="form-control form-control-sm col-md-4 mr-1 border rounded-pill mb-1 py-0" 
                            id="search_furnizor" name="search_furnizor" placeholder="Furnizor" autofocus
                                value="{{ $search_furnizor }}">
                        <div class="col-md-4 px-1">
                            <button class="btn btn-sm btn-primary col-md-12 border border-dark rounded-pill" type="submit">
                                <i class="fas fa-search text-white mr-1"></i>Caută
                            </button>
                        </div>
                        <div class="col-md-4 px-1">
                            <a class="btn btn-sm bg-secondary text-white col-md-12 border border-dark rounded-pill" href="{{ route('stocuri.index') }}" role="button">
                                <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            {{-- <div class="col-lg-3 text-right">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-pill col-md-8" href="{{ route('furnizori.create') }}" role="button">
                    <i class="fas fa-plus-square text-white mr-1"></i>Adaugă furnizor
                </a>
            </div>  --}}
        </div>

        <div class="card-body px-0 py-3">

            @include('errors')

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded"> 
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>Nr.</th>
                            <th>Produs</th>
                            <th>Furnizor</th>
                            <th>Cantitate</th>
                            <th>Data</th>
                            <th class="text-right">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>               
                        @forelse ($stocuri as $stoc) 
                            <tr>                  
                                <td align="">
                                    {{ ($stocuri ->currentpage()-1) * $stocuri ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    {{-- <a href="{{ $stoc->path() }}"> --}}
                                        {{ $stoc->produs_nume }}
                                    {{-- </a> --}}
                                </td>
                                <td>
                                    {{ $stoc->furnizor_nume }}
                                </td>
                                <td>
                                    {{ $stoc->cantitate - $stoc->cantitate_initiala}}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($stoc->created_at)->isoFormat('DD.MM.YYYY')}}
                                    
                                </td>
                                <td class="d-flex justify-content-end"> 
                                    <a href="{{ $stoc->path() }}/modifica"
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
                                            data-target="#stergestoc{{ $stoc->id }}"
                                            title="Șterge stoc"
                                            >
                                            {{-- <i class="far fa-trash-alt"></i> --}}
                                            <span class="badge badge-danger">Șterge</span>
                                        </a>
                                            <div class="modal fade text-dark" id="stergestoc{{ $stoc->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title text-white" id="exampleModalLabel">Stoc: <b>{{ $stoc->produs_nume }}</b></h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" style="text-align:left;">
                                                        Ești sigur ca vrei să ștergi stocul?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                                        
                                                        <form method="POST" action="{{ $stoc->path() }}">
                                                            @method('DELETE')  
                                                            @csrf   
                                                            <button 
                                                                type="submit" 
                                                                class="btn btn-danger"  
                                                                >
                                                                Șterge stoc
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
                            <div>Nu s-au gasit stocuri în baza de date. Încearcă alte date de căutare</div>
                        @endforelse
                        </tbody>
                </table>
            </div>

                <nav>
                    <ul class="pagination pagination-sm justify-content-center">
                        {{-- {{$produse_vandute->links()}} --}}
                        {{$stocuri->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection