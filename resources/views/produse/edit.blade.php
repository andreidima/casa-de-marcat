@extends ('layouts.app')

@section('content')  

    <div class="container card">
            <div class="row card-header">
                <div class="mt-2 mb-0">
                    <h4 class=""><a href="/produse"><i class="fas fa-list-ul mr-1"></i>Produse</a> / {{ $produse->nume }}</h4>
                </div> 
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        
                        @include ('errors')
                    
                        <div class="">
                            <form  class="needs-validation" novalidate method="POST" action="{{ $produse->path() }}">
                                @method('PATCH')
                                @csrf 

                            <div class="form-group row">
                                    <label for="nr_de_bucati" class="col-sm-5 col-form-label">Nume:</label>
                                <div class="col-sm-7">
                                    <input type="text"
                                        class="form-control {{ $errors->has('nume') ? 'is-invalid' : '' }}" 
                                        name="nume"
                                        placeholder="Nume"                                        
                                        value="{{ old('nume') == '' ? $produse->nume : old('nume') }}"
                                        >
                                </div>
                            </div>
                            <div class="form-group row">
                                    <label for="pret_de_achizitie" class="col-sm-5 col-form-label">Preț de achiziție:</label>
                                <div class="col-sm-7">
                                    <input type="number" min="1" step="any" 
                                        class="form-control {{ $errors->has('pret_de_achizitie') ? 'is-invalid' : '' }}" 
                                        name="pret_de_achizitie"
                                        placeholder="Preț"         
                                        value="{{ old('pret_de_achizitie') == '' ? $produse->pret_de_achizitie : old('pret_de_achizitie') }}"
                                        >
                                </div>
                            </div>
                            <div class="form-group row">
                                    <label for="pret" class="col-sm-5 col-form-label">Preț de vânzare:</label>
                                <div class="col-sm-7">
                                    <input type="number" min="1" step="any" 
                                        class="form-control {{ $errors->has('pret') ? 'is-invalid' : '' }}" 
                                        name="pret"
                                        placeholder="Preț"         
                                        value="{{ old('pret') == '' ? $produse->pret : old('pret') }}"
                                        >
                                </div>
                            </div>
                            <div class="form-group row">
                                    <label for="cantitate" class="col-sm-5 col-form-label">Cantitate:</label>
                                <div class="col-sm-7">
                                    <input type="number" min="1" max="9999999" 
                                        class="form-control {{ $errors->has('cantitate') ? 'is-invalid' : '' }}" 
                                        name="cantitate"
                                        placeholder="Cantitate"        
                                        value="{{ old('cantitate') == '' ? $produse->cantitate : old('cantitate') }}"
                                        >
                                </div>
                            </div>
                            <div class="form-group row">
                                    <label for="cod_de_bare" class="col-sm-5 col-form-label">Cod de bare:</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control {{ $errors->has('cod_de_bare') ? 'is-invalid' : '' }}" 
                                        name="cod_de_bare"
                                        placeholder="Cod de bare"         
                                        value="{{ old('cod_de_bare') == '' ? $produse->cod_de_bare : old('cod_de_bare') }}"
                                        >
                                </div>
                            </div>
                            <div class="form-group row">
                                    <label for="localizare" class="col-sm-5 col-form-label">Localizare:</label>
                                <div class="col-sm-7">                                      
                                    <textarea class="form-control {{ $errors->has('localizare') ? 'is-invalid' : '' }}" 
                                        name="localizare"
                                        placeholder="localizare"
                                        >{{ old('localizare') == '' ? $produse->localizare : old('localizare') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                    <label for="descriere" class="col-sm-5 col-form-label">Descriere:</label>
                                <div class="col-sm-7">                                      
                                    <textarea class="form-control {{ $errors->has('descriere') ? 'is-invalid' : '' }}" 
                                        name="descriere"
                                        placeholder="Descriere"
                                        >{{ old('descriere') == '' ? $produse->descriere : old('descriere') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-primary btn-lg py-2">Modifică produsul</button>
                                </div>
                            </div>  
                        </form>



@endsection
