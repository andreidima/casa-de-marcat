@extends ('layouts.app')

@section('content')  

    <div class="container card">
            <div class="row card-header">
                <div class="mt-2 mb-0">
                    <h4 class=""><a href="/produse/adauga"><i class="fas fa-list-ul mr-1"></i>Adaugă produs</a></h4>
                </div> 
            </div>
            <div class="card-body" id="adaugare_modificare_produse">
                <div class="row justify-content-center">
                    <div class="col-lg-5">     
                        
                        @include ('errors')
                    
                        <div class="">
                            <form  class="needs-validation" novalidate method="POST" action="/produse">
                                @csrf 

                            <div class="form-group row">
                                    <label for="nr_de_bucati" class="col-sm-5 col-form-label">Nume:</label>
                                <div class="col-sm-7">
                                    <input type="text"
                                        class="form-control {{ $errors->has('nume') ? 'is-invalid' : '' }}" 
                                        name="nume"
                                        placeholder="Nume"                                        
                                        value="{{ old('nume')}}"
                                        >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="categorie_produs_id" class="col-sm-5 col-form-label">Categorie:</label>
                                <div class="col-sm-7">    
                                    <script type="application/javascript"> 
                                        categorieVeche={!! json_encode(old('categorie_produs_id', "0")) !!}
                                    </script>                                     
                                    <select name="categorie_produs_id" 
                                        class="custom-select {{ $errors->has('categorie_produs_id') ? 'is-invalid' : '' }}" 
                                        v-model="categorie"                                       
                                        @change="getSubcategorii()"
                                    >
                                            {{-- <option value='' selected>Selectează</option> --}}
                                        @foreach ($categorii_produs as $categorie)                           
                                            <option 
                                                value='{{ $categorie->id }}'
                                                    @if(old('categorie_produs_id') !== null)
                                                        @if ($categorie->id == old('categorie_produs_id'))
                                                            selected
                                                        @endif
                                                    {{-- @else
                                                        @if ($categorie->id == $produse->categorie_produs_id)
                                                            selected
                                                        @endif --}}
                                                    @endif
                                            >{{ $categorie->nume }} </option>                                                
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="subcategorie_produs_id" class="col-sm-5 col-form-label">Subcategorie:</label>
                                <div class="col-sm-7">    
                                    <script type="application/javascript"> 
                                        subcategorieVeche={!! json_encode(old('subcategorie_produs_id', "0")) !!}
                                    </script>                                     
                                    <select name="subcategorie_produs_id" 
                                        class="custom-select {{ $errors->has('subcategorie_produs_id') ? 'is-invalid' : '' }}" 
                                        v-model="subcategorie"                
                                    > 
                                        <option v-for='subcategorie in subcategorii'                                
                                        :value='subcategorie.id'                                       
                                        >@{{subcategorie.nume}}</option>    
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                    <label for="pret_de_achizitie" class="col-sm-5 col-form-label">Preț de achiziție:</label>
                                <div class="col-sm-7">
                                    <input type="number" min="1" step="any" 
                                        class="form-control {{ $errors->has('pret_de_achizitie') ? 'is-invalid' : '' }}" 
                                        name="pret_de_achizitie"
                                        placeholder="Preț de achiziție"                                        
                                        value="{{ old('pret_de_achizitie') }}"
                                        >
                                </div>
                            </div>
                            <div class="form-group row">
                                    <label for="pret" class="col-sm-5 col-form-label">Preț de vânzare:</label>
                                <div class="col-sm-7">
                                    <input type="number" min="1" step="any" 
                                        class="form-control {{ $errors->has('pret') ? 'is-invalid' : '' }}" 
                                        name="pret"
                                        placeholder="Preț de vânzare"                                        
                                        value="{{ old('pret') }}"
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
                                        value="{{ old('cantitate') }}"                                        
                                        >
                                </div>
                            </div>
                            <div class="form-group row">
                                    <label for="cod_de_bare" class="col-sm-5 col-form-label">
                                        Cod de bare:
                                        <small>({{ $cod_de_bare->prefix . $cod_de_bare->numar }})</small>
                                    </label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control {{ $errors->has('cod_de_bare') ? 'is-invalid' : '' }}" 
                                        name="cod_de_bare"
                                        placeholder="Cod de bare"                                        
                                        value="{{ old('cod_de_bare') ?? $cod_de_bare->prefix . $cod_de_bare->numar }}"
                                        v-on:keydown.enter.prevent
                                        >
                                </div>
                            </div>
                            <div class="form-group row">
                                    <label for="imei" class="col-sm-5 col-form-label">
                                        IMEI:
                                    </label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control {{ $errors->has('imei') ? 'is-invalid' : '' }}" 
                                        name="imei"
                                        placeholder="Cod de bare"                                        
                                        value="{{ old('imei') }}"
                                        >
                                </div>
                            </div>
                            {{-- <div class="form-group row">
                                    <label for="localizare" class="col-sm-5 col-form-label">Localizare:</label>
                                <div class="col-sm-7">
                                    <textarea class="form-control {{ $errors->has('localizare') ? 'is-invalid' : '' }}" 
                                        name="localizare"
                                        placeholder="localizare"
                                        >{{ old('localizare') }}</textarea>
                                </div>
                            </div> --}}
                            <div class="form-group row">
                                    <label for="descriere" class="col-sm-5 col-form-label">Descriere:</label>
                                <div class="col-sm-7">
                                    <textarea class="form-control {{ $errors->has('descriere') ? 'is-invalid' : '' }}" 
                                        name="descriere"
                                        placeholder="Descriere"
                                        >{{ old('descriere') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-primary btn-lg py-2">Adaugă produsul</button>
                                </div>
                            </div>  
                        </form>



@endsection
