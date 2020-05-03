@csrf

<div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="form-row px-2 py-2 mb-0">    
            <div class="form-group col-lg-12 mb-2">  
                <label for="nume" class="mb-0 pl-3">Nume:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nume') ? 'is-invalid' : '' }}" 
                    name="nume" 
                    placeholder="" 
                    value="{{ old('nume') == '' ? $furnizori->nume : old('nume') }}"
                    required> 
            </div>                           
            <div class="form-group col-lg-6 mb-2">  
                <label for="localitate" class="mb-0 pl-1">Localitate:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('localitate') ? 'is-invalid' : '' }}" 
                    name="localitate" 
                    placeholder="" 
                    value="{{ old('localitate') == '' ? $furnizori->localitate : old('suma') }}"
                    required> 
            </div>   
            <div class="form-group col-lg-6 mb-2">  
                <label for="cod_fiscal" class="mb-0 pl-3">Cod fiscal:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('cod_fiscal') ? 'is-invalid' : '' }}" 
                    name="cod_fiscal" 
                    placeholder="" 
                    value="{{ old('cod_fiscal') == '' ? $furnizori->cod_fiscal : old('cod_fiscal') }}"
                    required> 
            </div> 
        </div>
        
                                
        <div class="form-row mb-3 px-2 justify-content-center">                                    
            <div class="col-lg-8 d-flex justify-content-center">  
                <button type="submit" class="btn btn-primary btn-sm mr-2 rounded-pill">{{ $buttonText }}</button> 
                {{-- <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="{{ $clienti->path() }}">Renunță</a>  --}}
                <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="/furnizori">Renunță</a> 
            </div>
        </div>
    </div>
</div>