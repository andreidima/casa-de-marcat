@extends ('layouts.app')

@section('content')   
    <div class="container card">
        <div class="row card-header">
            <div class="col-lg-4 my-1">
                <h4 class="mt-2 mb-0"><a href="/produse"><i class="fas fa-list-ul mr-1"></i>Produse</a></h4>
            </div> 
            <div class="col-lg-4 my-1" id="produse">
                <form class="needs-validation" novalidate method="GET" action="/produse">
                    @csrf                    
                    <div class="input-group custom-search-form justify-content-center">
                        <div class="">
                            <input type="text" class="form-control" id="search_cod_de_bare" name="search_cod_de_bare" placeholder="Caută cod de bare" autofocus>
                            {{-- <small class="form-text text-muted">Caută după cod de bare</small> --}}
                        </div>
                        <div class="">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search text-white"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 text-right my-1">
                <a class="btn btn-primary" href="/produse/adauga" role="button">Adaugă Produs</a>
            </div>
        </div>

        <div class="card-body">

            @if (session()->has('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped"> 
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th>Nr. crt.</th>
                            <th>Produs</th>
                            <th>Preț</th>
                            <th class="text-center">Cantitatea</th>
                            <th>Cod de bare</th>
                            {{-- <th>Localizare</th> --}}
                            {{-- <th class="px-0" style="width:20px">Descriere</th> --}}
                            <th class="px-0" style="width:115px">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>               
                        @forelse ($produse as $produs) 
                            <tr>                    
                                <td align="center">
                                    {{ ($produse ->currentpage()-1) * $produse ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    <a href="{{ $produs->path() }}">  
                                        <b>{{ $produs->nume }}</b>
                                    </a>
                                </td>
                                <td class="text-right">
                                    {{ $produs->pret }} lei
                                </td>
                                <td class="text-center">
                                    {{ $produs->cantitate }}
                                </td>
                                <td class="text-center">
                                    {{ $produs->cod_de_bare }}
                                </td>
                                {{-- <td class="text-center">
                                    {{ $produs->localizare }}
                                </td> --}}
                                {{-- <td class="my-0 py-1 text-center">
                                    <img src="{{ asset('images/tourist-information-symbol-iso-sign-is-1293.png') }}" 
                                        title="{{ $produs->descriere }}"
                                        height="30" class="my-1">
                                    <button type="button" class="btn btn-info btn-sm text-white" title="{{ $produs->descriere }}">
                                        <i class="fas fa-info-circle"></i>  
                                    </button>                              
                                </td> --}}
                                 <td class="d-flex justify-content-end">   
                                        <a 
                                            href="{{ $produs->path() }}/export/barcode-pdf" 
                                            class="flex mr-4"
                                            title="Generează Barcode"
                                            target="_blank"
                                            >
                                            <span class="badge badge-success">Barcode</span>
                                        </a>
                                        <a class="flex" 
                                            href="{{ $produs->path() }}/modifica"
                                            title="Editează Produsul"
                                            >
                                            <span class="badge badge-primary">Modifică</span>
                                        </a>
                                        <div style="flex" class="">
                                            <a
                                                href="#" 
                                                {{-- role="button" --}}
                                                data-toggle="modal" 
                                                data-target="#stergeProdus{{ $produs->id }}"
                                                title="Șterge Produsul"
                                                >
                                                <span class="badge badge-danger">Șterge</span>
                                            </a>
                                                <div class="modal fade text-dark" id="stergeProdus{{ $produs->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                            <h5 class="modal-title text-white" id="exampleModalLabel">Produs: <b>{{ $produs->nume }}</b></h5>
                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="text-align:left;">
                                                            Ești sigur ca vrei să ștergi produsul?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                                            
                                                            <form method="POST" action="{{ $produs->path() }}">
                                                                @method('DELETE')  
                                                                @csrf   
                                                                <button 
                                                                    type="submit" 
                                                                    class="btn btn-danger"  
                                                                    >
                                                                    Șterge Produsul
                                                                </button>                    
                                                            </form>
                                                        
                                                        </div>
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
                {{-- <p class="text-center">
                Pagina nr. {{$rezervari->currentPage()}}
                </p>

                <nav>
                    <ul class="pagination justify-content-center">
                        {{$rezervari->links()}}
                    </ul>
                </nav>  --}}

                {{-- <div class="container">
                    @foreach ($produse as $produs)
                        {{ $produs->name }}
                    @endforeach
                </div> --}}

                <nav>
                    <ul class="pagination justify-content-center">
                        {{$produse->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection