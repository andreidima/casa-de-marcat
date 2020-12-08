@extends ('layouts.app')

@section('content')   
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header justify-content-between py-1" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-4 align-self-center">
                <h4 class=" mb-0">
                    <a href="{{ route('produse-inventar-verificare.produse-lipsa') }}"><i class="fas fa-boxes mr-1"></i>Produse lipsă</a>
                </h4>
            </div> 
            <div class="col-lg-8" id="">
                <form class="needs-validation" novalidate method="GET" action="{{ route('produse-inventar-verificare.produse-lipsa') }}">
                    @csrf                    
                    <div class="row input-group custom-search-form justify-content-center align-self-end">
                        <div class="col-lg-6 px-0">
                            <input type="text" class="form-control form-control-sm border rounded-pill mb-1 py-0" 
                            id="search_nume" name="search_nume" placeholder="Nume" autofocus
                                    value="{{ $search_nume }}">
                        </div>
                        <div class="col-lg-3 px-0">
                            <input type="text" class="form-control form-control-sm border rounded-pill mb-1 py-0" 
                            id="search_cod_de_bare" name="search_cod_de_bare" placeholder="Cod de bare" autofocus
                                    value="{{ $search_cod_de_bare }}">
                        </div>
                        <div class="col-lg-3 px-0">                                   
                            <select name="search_subcategorie_produs_id" 
                                class="custom-select custom-select-sm border rounded-pill {{ $errors->has('search_subcategorie_produs_id') ? 'is-invalid' : '' }}" 
                            >
                                <option value='' selected>Selectează categorie</option>
                                @foreach ($subcategorii as $subcategorie)                           
                                    <option 
                                        value='{{ $subcategorie->id }}'
                                        @if ($subcategorie->id == $search_subcategorie_produs_id)
                                            selected
                                        @endif
                                    >{{ $subcategorie->nume }} </option>                                                
                                @endforeach
                            </select>
                        </div>
                        <button class="btn btn-sm btn-primary col-md-3 mr-1 border border-dark rounded-pill" type="submit">
                            <i class="fas fa-search text-white mr-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-3 border border-dark rounded-pill" href="{{ route('produse-inventar-verificare.produse-lipsa') }}" role="button">
                            <i class="fas fa-undo text-white mr-1"></i>Resetează căutarea
                        </a>
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
                            <th>Nr. Crt.</th>
                            <th class="">Produs</th>
                            <th class="">Cod de bare</th>
                            <th class="text-center">Cantitate în baza de date</th>
                            <th class="text-center">Cantitate la inventar</th>
                        </tr>
                    </thead>
                    <tbody>               
                        @forelse ($produse_lipsa as $produs_lipsa) 
                            <tr>                  
                                <td align="">
                                    {{ ($produse_lipsa ->currentpage()-1) * $produse_lipsa ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    {{-- <a class="" data-toggle="collapse" href="#collapse{{ $produs_lipsa->id }}" role="button" 
                                        aria-expanded="false" aria-controls="collapse{{ $produs_lipsa->id }}"> --}}
                                    {{-- <a href="{{ isset($produs_lipsa->produs) ? $produs_lipsa->produs->path() : ''}}"> --}}
                                        <b>{{ $produs_lipsa->nume }}</b>
                                    {{-- </a> --}}
                                </td>
                                <td>
                                    {{ $produs_lipsa->cod_de_bare }}
                                </td>
                                <td class="text-center">
                                    {{ $produs_lipsa->produs_cantitate }}
                                </td>
                                <td class="text-center">
                                    {{ $produs_lipsa->produs_inventar_verificare_cantitate ?? 0 }}
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
                        {{-- {{$produse_lipsae->links()}} --}}
                        {{$produse_lipsa->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection