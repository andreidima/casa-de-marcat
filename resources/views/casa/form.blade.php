@csrf

<div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="form-row px-2 py-2 mb-0 d-flex justify-content-center">                          
            <div class="form-group col-lg-4 mb-2">  
                <label for="suma" class="mb-0 pl-1">Suma:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('suma') ? 'is-invalid' : '' }}" 
                    name="suma" 
                    placeholder="" 
                    value="{{ old('suma') == '' ? $casa->suma : old('suma') }}"
                    required> 
            </div>   
        </div>
        
                                
        <div class="form-row mb-3 px-2 justify-content-center">                                    
            <div class="col-lg-8 d-flex justify-content-center">  
                <button type="submit" class="btn btn-primary btn-sm mr-2 rounded-pill">{{ $buttonText }}</button> 
                {{-- <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="{{ $clienti->path() }}">Renunță</a>  --}}
                <a class="btn btn-secondary btn-sm rounded-pill" href="/avansuri">Renunță</a> 
            </div>
        </div>
    </div>
</div>