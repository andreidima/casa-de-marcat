@extends ('layouts.app')

@section('content')   
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header justify-content-between py-1" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3 align-self-center">
                <h4 class=" mb-0">
                    <a href="{{ route('avansuri.index') }}"><i class="fas fa-hand-holding-usd mr-1"></i></i>Avans</a>
                </h4>
            </div> 
            <div class="col-lg-6" id="">
                <form class="needs-validation" novalidate method="GET" action="{{ route('avansuri.index') }}">
                    @csrf                    
                    <div class="row input-group custom-search-form justify-content-center">
                        <input type="text" class="form-control form-control-sm col-md-4 mr-1 border rounded-pill mb-1 py-0" 
                        id="search_nume" name="search_nume" placeholder="Nume" autofocus
                                value="{{ $search_nume }}">
                        <button class="btn btn-sm btn-primary col-md-4 mr-1 border border-dark rounded-pill" type="submit">
                            <i class="fas fa-search text-white mr-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-pill" href="{{ route('avansuri.index') }}" role="button">
                            <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 text-right">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-pill col-md-8" href="{{ route('avansuri.create') }}" role="button">
                    <i class="fas fa-plus-square text-white mr-1"></i>Adaugă avans
                </a>
            </div> 
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
                            <th 
                                {{-- style="width:30%" --}}
                            >Nume</th>
                            <th class="text-center">Descriere</th>
                            <th class="text-center">Suma</th>
                            <th class="text-right">Data avans</th>
                            <th class="text-center">Stare</th>
                            <th class="text-center">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>               
                        @forelse ($avansuri as $avans) 
                            <tr>                  
                                <td align="">
                                    {{ ($avansuri ->currentpage()-1) * $avansuri ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    <a href="{{ $avans->path() }}">
                                        {{ $avans->nume ?? '' }}
                                    </a>
                                </td>
                                <td class="">
                                    {{ $avans->descriere }}
                                </td>
                                <td class="text-right">
                                    {{ $avans->suma }} lei
                                </td>
                                <td class="text-right">
                                    {{ \Carbon\Carbon::parse($avans->created_at)->isoFormat('HH:MM - DD.MM.YYYY') ?? '' }}
                                </td>
                                <td class="text-center">
                                    @if ($avans->stare === 1)  
                                        <a class="" 
                                            href="#" 
                                            role="button"
                                            data-toggle="modal" 
                                            data-target="#activeazaAnuleazaAvans{{ $avans->id }}"
                                            title=""
                                            >
                                            <span class="badge badge-success">Deschis</span>
                                        </a>
                                    @else
                                        <a class="" 
                                            href="#" 
                                            role="button"
                                            data-toggle="modal" 
                                            data-target="#activeazaAnuleazaAvans{{ $avans->id }}"
                                            title=""
                                            >
                                            <span class="badge badge-dark">Închis</span>
                                        </a>
                                    @endif 

                                        <div class="modal fade text-dark" id="activeazaAnuleazaAvans{{ $avans->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header bg-warning">
                                                    <h5 class="modal-title" id="exampleModalLabel">Avans: <b>{{ $avans->nume }}</b></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" style="text-align:left;">
                                                    @if ($avans->stare === 1) 
                                                        Ești sigur ca vrei să închizi avansul?
                                                    @else
                                                        Ești sigur ca vrei să deschizi avansul?
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                                    
                                                    <form method="POST" action="{{ url('avansuri/deschide-inchide', $avans->id) }}">
                                                        @method('PATCH')
                                                        @csrf 
                                                            @if ($avans->stare === 1)  
                                                                <button type="submit" class="btn btn-warning">
                                                                    Închide Avans
                                                                </button> 
                                                            @else
                                                                <button type="submit" class="btn btn-success">
                                                                    Deschide Avans
                                                                </button> 
                                                            @endif                     
                                                    </form>
                                                
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                </td>
                                <td class="d-flex justify-content-end"> 
                                    <a href="{{ $avans->path() }}/modifica"
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
                                            data-target="#stergeAvans{{ $avans->id }}"
                                            title="Șterge Avans"
                                            >
                                            {{-- <i class="far fa-trash-alt"></i> --}}
                                            <span class="badge badge-danger">Șterge</span>
                                        </a>
                                            <div class="modal fade text-dark" id="stergeAvans{{ $avans->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title text-white" id="exampleModalLabel">Avans: <b>{{ $avans->nume }}</b></h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" style="text-align:left;">
                                                        Ești sigur ca vrei să ștergi Avansul?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                                        
                                                        <form method="POST" action="{{ $avans->path() }}">
                                                            @method('DELETE')  
                                                            @csrf   
                                                            <button 
                                                                type="submit" 
                                                                class="btn btn-danger"  
                                                                >
                                                                Șterge Avans
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
                        {{$avansuri->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection