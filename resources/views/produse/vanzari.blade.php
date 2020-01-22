@extends ('layouts.app')

@section('content')   
    <div class="container card">
            <div class="row card-header">
                <div class="mt-2 mb-0">
                    <h4 class=""><a href="/produse/vanzari"><i class="fas fa-file-alt mr-1"></i>Vânzări produse</a></h4>
                </div> 
            </div>
            <div class="card-body">
                <div class="row justify-content-around">
                    <div class="col-lg-5 card px-0" id="vanzari"> 

                        <div class="card-header text-center pb-0">
                            <i class="fas fa-barcode text-primary" style="font-size:50px"></i>
                            <br>
                            Scanează produsul
                        </div>      
                        
                        <div class="card-body">
                            {{-- @include('/flash-message') --}}
                            @include('errors')

                            <form  class="needs-validation" novalidate method="POST" 
                                action="{{ action('ProdusController@vanzariDescarcaProdus') }}"
                            >
                                @method('PATCH')
                                @csrf  

                                <div class="form-group row">
                                        <label for="cod_de_bare" class="col-sm-7 col-form-label">Scanați codul de bare:</label>
                                    <div class="col-sm-5">                                        
                                        <script type="application/javascript"> 
                                            codDeBareVechi={!! json_encode(old('cod_de_bare', "")) !!}
                                        </script>
                                        <input type="text" class="form-control {{ $errors->has('cod_de_bare') ? 'is-invalid' : '' }}" 
                                            id="cod_de_bare" 
                                            name="cod_de_bare"
                                            placeholder="Cod de bare"                                        
                                            value="{{ old('cod_de_bare') }}"
                                            autofocus
                                            autocomplete="off"
                                            v-model="cod_de_bare" 
                                            @change="getPret()"
                                            v-on:keydown.enter.prevent
                                            >
                                    </div>
                                </div>
                                <div class="form-group row">
                                        <label for="nr_de_bucati" class="col-sm-7 col-form-label">Număr de bucăți:</label>
                                    <div class="col-sm-5">
                                        <input type="number" min="1" max="99"
                                            class="form-control {{ $errors->has('nr_de_bucati') ? 'is-invalid' : '' }}" 
                                            id="nr_de_bucati" 
                                            name="nr_de_bucati"
                                            placeholder="1"                                        
                                            value="{{ old('nr_de_bucati') == '' ? '0' : old('nr_de_bucati') }}"
                                            autocomplete="off"
                                            >
                                    </div>
                                </div>
                                <div class="form-group row">
                                        <label for="pret" class="col-sm-7 col-form-label">Preț:</label>
                                    <div class="col-sm-5">
                                        <input type="text"
                                            class="form-control {{ $errors->has('pret') ? 'is-invalid' : '' }}" 
                                            id="pret" 
                                            name="pret"
                                            v-model="pret"                                        
                                            value="{{ old('pret')}}"
                                            autocomplete="off"
                                            >
                                    </div>
                                </div>
                                <div class="form-group row">
                                        <label for="detalii" class="col-sm-7 col-form-label">Detalii:</label>
                                    <div class="col-sm-5">
                                        <input type="text"
                                            class="form-control {{ $errors->has('detalii') ? 'is-invalid' : '' }}" 
                                            id="detalii" 
                                            name="detalii"                                      
                                            value="{{ old('detalii')}}"
                                            autocomplete="off"
                                            >
                                    </div>
                                </div>
                                <div class="form-group row justify-content-end">
                                        {{-- <label for="pret" class="col-sm-6 col-form-label">Preț:</label> --}}
                                            <div class="form-check col-sm-3 text-center">
                                                <input type="checkbox" class="form-check-input" name="card" value="1"
                                                {{ old('card') == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="card">Card</label>
                                            </div>
                                            <div class="form-check col-sm-2">
                                                <input type="checkbox" class="form-check-input" name="emag" value="1"
                                                {{ old('emag') == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="emag">Emag</label>
                                            </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12 d-flex justify-content-around">

                                        <button type="submit" class="btn btn-primary btn-lg py-2">Vinde produsul</button>
                                    </div>
                                </div>  
                            </form>
                        </div>
                        
                    </div>

                    <div class="col-lg-4 card px-0">
                        <div class="card-header text-center pb-0">
                            <i class="fas fa-shopping-cart text-primary" style="font-size:50px"></i>
                            <br>
                            Lista ultimelor produse vândute:
                        </div>    
                        <div class="card-body">                    
                            @if (session()->has('produse_vandute'))
                                <div class="alert alert-success text-center">
                                    @foreach(Session::get('produse_vandute') as $produs_vandut => $produs)
                                        {{ $produs }}
                                        <br>
                                    @endforeach
                                </div>
                                <div class="text-center">
                                    <a class="btn btn-danger btn-lg py-2" href="/produse/vanzari/goleste-cos" role="button">Golește lista</a>
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