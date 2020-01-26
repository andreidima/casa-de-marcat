@extends ('layouts.app')

@section('content')   
    <div class="container card">
            <div class="row card-header">
                <div class="mt-2 mb-0">
                    <h4 class=""><a href="/produse-inventar-verificare/adauga"><i class="fas fa-boxes mr-1"></i>Adaugă produse în lista de inventar</a></h4>
                </div> 
            </div>
            <div class="card-body">
                <div class="row justify-content-around">
                    <div class="col-lg-5 card px-0"> 

                        <div class="card-header text-center pb-0">
                            <i class="fas fa-barcode text-primary" style="font-size:50px"></i>
                            <br>
                            Scanează produsul
                        </div>      
                        
                        <div class="card-body">

                            @include('errors')

                            <form  class="needs-validation" novalidate method="POST" 
                                action="/produse-inventar-verificare"
                            >
                                {{-- @method('POST') --}}
                                @csrf  

                                <div class="form-group row">
                                        <label for="nr_de_bucati" class="col-sm-6 col-form-label">Număr de bucăți:</label>
                                    <div class="col-sm-6">
                                        <input type="number" min="1" max="99"
                                            class="form-control {{ $errors->has('nr_de_bucati') ? 'is-invalid' : '' }}" 
                                            id="nr_de_bucati" 
                                            name="nr_de_bucati"
                                            placeholder="Nr. de bucăți"                                        
                                            value="{{ old('nr_de_bucati') == '' ? '' : old('nr_de_bucati') }}"
                                            autofocus
                                            autocomplete="off"
                                            >
                                    </div>
                                </div>
                                <div class="form-group row">
                                        <label for="cod_de_bare" class="col-sm-6 col-form-label">Scanați codul de bare:</label>
                                    <div class="col-sm-6"> 
                                        <input type="text" class="form-control {{ $errors->has('cod_de_bare') ? 'is-invalid' : '' }}" 
                                            id="cod_de_bare" 
                                            name="cod_de_bare"
                                            placeholder="Cod de bare"                                        
                                            value=""
                                            autocomplete="off"
                                            {{-- autofocus --}}
                                            >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12 d-flex justify-content-around">

                                        <button type="submit" class="btn btn-primary btn-lg py-2">Adaugă produsul</button>
                                    </div>
                                </div>  
                            </form>
                        </div>
                        
                    </div>

                    <div class="col-lg-4 card px-0">
                        <div class="card-header text-center pb-0">
                            <i class="fas fa-cart-plus text-primary" style="font-size:50px"></i>
                            <br>
                            Lista ultimelor produse adăugate:
                        </div>    
                        <div class="card-body">                    
                            @if (session()->has('produse_inventar_verificare'))
                                <div class="alert alert-success text-center">
                                    @foreach(Session::get('produse_inventar_verificare') as $produs_inventar => $produs)
                                        {{ $produs }}
                                        <br>
                                    @endforeach
                                </div>
                                <div class="text-center">
                                    <a class="btn btn-danger btn-lg py-2" href="/produse_inventar_verificare/goleste-lista" role="button">Golește lista</a>
                                </div>
                            @else
                                <div class="alert alert-info text-center">
                                    Lista este goală.
                                </div>                                
                            @endif
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection