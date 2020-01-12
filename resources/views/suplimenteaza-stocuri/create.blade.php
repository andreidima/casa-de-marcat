@extends ('layouts.app')

@section('content')   
    <div class="container card">
            <div class="row card-header">
                <div class="mt-2 mb-0">
                    <h4 class=""><a href="/suplimenteaza-stocuri/adauga"><i class="fas fa-cart-plus mr-1"></i>Suplimentează stocuri</a></h4>
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
                                action="{{ action('SuplimenteazaStocController@store') }}"
                            >
                                @method('PATCH')
                                @csrf  

                                <div class="form-group row">
                                        <label for="cod_de_bare" class="col-sm-6 col-form-label">Scanați codul de bare:</label>
                                    <div class="col-sm-6"> 
                                        <input type="text" class="form-control {{ $errors->has('cod_de_bare') ? 'is-invalid' : '' }}" 
                                            id="cod_de_bare" 
                                            name="cod_de_bare"
                                            placeholder="Cod de bare"                                        
                                            value="{{ old('cod_de_bare') }}"
                                            autofocus
                                            >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12 d-flex justify-content-around">

                                        <button type="submit" class="btn btn-primary btn-lg py-2">Suplimentează stocul produsului</button>
                                    </div>
                                </div>  
                            </form>
                        </div>
                        
                    </div>

                    <div class="col-lg-4 card px-0">
                        <div class="card-header text-center pb-0">
                            <i class="fas fa-cart-plus text-primary" style="font-size:50px"></i>
                            <br>
                            Lista ultimelor stocuri suplimentate:
                        </div>    
                        <div class="card-body">                    
                            @if (session()->has('suplimentare_stocuri'))
                                <div class="alert alert-success text-center">
                                    @foreach(Session::get('suplimentare_stocuri') as $stoc_suplimentat => $produs)
                                        {{ $produs }}
                                        <br>
                                    @endforeach
                                </div>
                                <div class="text-center">
                                    <a class="btn btn-danger btn-lg py-2" href="/suplimenteaza-stocuri/goleste-lista" role="button">Golește lista</a>
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