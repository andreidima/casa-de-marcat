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

                            {{-- @php
                                dd($furnizor_id ?? '');
                            @endphp --}}

                            <form  class="needs-validation" novalidate method="POST" 
                                action="{{ action('SuplimenteazaStocController@store') }}"
                            >
                                @method('PATCH')
                                @csrf  

                                <div class="form-group row">
                                    <label for="furnizor_id" class="col-sm-6 col-form-label">Furnizor:</label>
                                    <div class="col-sm-6">                                     
                                        <select name="furnizor_id" 
                                            class="custom-select {{ $errors->has('furnizor_id') ? 'is-invalid' : '' }}" 
                                        >
                                                <option value='' selected>Selectează</option>
                                            @foreach ($furnizori as $furnizor)                           
                                                <option 
                                                    value='{{ $furnizor->id }}'
                                                        @if(old('furnizor_id') !== null)
                                                            @if ($furnizor->id == old('furnizor_id'))
                                                                selected
                                                            @endif
                                                        @else
                                                            @isset ($furnizor_id)
                                                                @if ($furnizor_id == $furnizor->id)
                                                                    selected
                                                                @endif
                                                            @endisset
                                                        @endif
                                                >{{ $furnizor->nume }} </option>                                                
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                        <label for="nr_factura" class="col-sm-6 col-form-label">Număr factură:</label>
                                    <div class="col-sm-6">
                                        <input type="text"
                                            class="form-control {{ $errors->has('nr_factura') ? 'is-invalid' : '' }}" 
                                            id="nr_factura" 
                                            name="nr_factura"
                                            placeholder="Nr. factură"                                        
                                            value="{{ old('nr_factura') == '' ? '' : old('nr_factura') }}"
                                            autofocus
                                            autocomplete="off"
                                            >
                                    </div>
                                </div>
                                <div class="form-group row">
                                        <label for="pret_de_achizitie" class="col-sm-6 col-form-label">Preț de achiziție:</label>
                                    <div class="col-sm-6">
                                        <input type="number" min="1" step="any" 
                                            class="form-control {{ $errors->has('pret_de_achizitie') ? 'is-invalid' : '' }}" 
                                            name="pret_de_achizitie"
                                            placeholder="Preț de achiziție"                                        
                                            value="{{ old('pret_de_achizitie') }}"
                                            >
                                    </div>
                                </div>
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
                                <div class="form-group row justify-content-end">
                                            <div class="form-check col-sm-3 text-center">
                                                <input type="checkbox" class="form-check-input" name="fara_nir" value="1"
                                                {{ old('fara_nir') == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="fara_nir">Fără nir</label>
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