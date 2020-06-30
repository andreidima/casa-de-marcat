@csrf


<div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="form-row px-2 py-2 mb-0">    
            <div class="form-group col-lg-12 mb-2">  
                <label for="firma" class="mb-0 pl-3">Firma:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('firma') ? 'is-invalid' : '' }}" 
                    name="firma" 
                    placeholder="" 
                    value="{{ old('firma') == '' ? $clienti->firma : old('firma') }}"
                    required> 
            </div>                           
            <div class="form-group col-lg-6 mb-2">  
                <label for="nr_reg_com" class="mb-0 pl-3">Nr. Reg. com.:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nr_reg_com') ? 'is-invalid' : '' }}" 
                    name="nr_reg_com" 
                    placeholder="" 
                    value="{{ old('nr_reg_com') == '' ? $clienti->nr_reg_com : old('nr_reg_com') }}"
                    required> 
            </div>                             
            <div class="form-group col-lg-6 mb-2">  
                <label for="cif_cnp" class="mb-0 pl-3">CIF/CNP:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('cif_cnp') ? 'is-invalid' : '' }}" 
                    name="cif_cnp" 
                    placeholder="" 
                    value="{{ old('cif_cnp') == '' ? $clienti->cif_cnp : old('cif_cnp') }}"
                    required> 
            </div>                           
            <div class="form-group col-lg-12 mb-2">  
                <label for="adresa" class="mb-0 pl-3">Adresa:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('adresa') ? 'is-invalid' : '' }}" 
                    name="adresa" 
                    placeholder="" 
                    value="{{ old('adresa') == '' ? $clienti->adresa : old('adresa') }}"
                    required> 
            </div>                                                     
            <div class="form-group col-lg-12 mb-2">  
                <label for="delegat" class="mb-0 pl-3">Delegat:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('delegat') ? 'is-invalid' : '' }}" 
                    name="delegat" 
                    placeholder="" 
                    value="{{ old('delegat') == '' ? $clienti->delegat : old('delegat') }}"
                    required> 
            </div>                                                   
            <div class="form-group col-lg-6 mb-2">  
                <label for="seria_nr_buletin" class="mb-0 pl-3">Seria nr buletin:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('seria_nr_buletin') ? 'is-invalid' : '' }}" 
                    name="seria_nr_buletin" 
                    placeholder="" 
                    value="{{ old('seria_nr_buletin') == '' ? $clienti->seria_nr_buletin : old('seria_nr_buletin') }}"
                    required> 
            </div>
            <div class="form-group col-lg-6 mb-4">  
                <label for="telefon" class="mb-0 pl-3">Telefon:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('telefon') ? 'is-invalid' : '' }}" 
                    name="telefon" 
                    placeholder="" 
                    value="{{ old('telefon') == '' ? $clienti->telefon : old('telefon') }}"
                    required> 
            </div>
        </div>
        
                                
        <div class="form-row mb-3 px-2 justify-content-center">                                    
            <div class="col-lg-8 d-flex justify-content-center">  
                <button type="submit" class="btn btn-primary btn-sm mr-2 rounded-pill">{{ $buttonText }}</button> 
                {{-- <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="{{ $clienti->path() }}">Renunță</a>  --}}
                <a class="btn btn-secondary btn-sm rounded-pill" href="/clienti">Renunță</a> 
            </div>
        </div>
    </div>
</div>