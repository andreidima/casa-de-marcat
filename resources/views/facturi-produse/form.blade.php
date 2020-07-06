@csrf

<div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="form-row px-2 py-2 mb-0">  
            <div class="form-group col-lg-9 mb-2"> 
                <label for="nume" class="mb-0 pl-3">Nume:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nume') ? 'is-invalid' : '' }}" 
                    name="nume" 
                    placeholder="" 
                    value="{{ old('nume') == '' ? $facturi_produse->nume : old('nume') }}"
                    required> 
            </div> 
            <div class="form-group col-lg-3 mb-2"> 
                <label for="um" class="mb-0 pl-3">UM:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('um') ? 'is-invalid' : '' }}" 
                    name="um" 
                    placeholder="" 
                    value="{{ old('um') == '' ? $facturi_produse->um : old('um') }}"
                    required> 
            </div>
            <div class="form-group col-lg-3 mb-2"> 
                <label for="cantitate" class="mb-0 pl-3">Cantitate:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('cantitate') ? 'is-invalid' : '' }}" 
                    name="cantitate" 
                    placeholder="" 
                    value="{{ old('cantitate') == '' ? $facturi_produse->cantitate : old('cantitate') }}"
                    required> 
            </div>
            <div class="form-group col-lg-3 mb-2"> 
                <label for="pret_unitar" class="mb-0 pl-3">Pret unitar:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('pret_unitar') ? 'is-invalid' : '' }}" 
                    name="pret_unitar" 
                    placeholder="" 
                    value="{{ old('pret_unitar') == '' ? $facturi_produse->pret_unitar : old('pret_unitar') }}"
                    required> 
            </div>
            <div class="form-group col-lg-3 mb-2"> 
                <label for="valoare" class="mb-0 pl-3">Valoare:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('valoare') ? 'is-invalid' : '' }}" 
                    name="valoare" 
                    placeholder="" 
                    value="{{ old('valoare') == '' ? $facturi_produse->valoare : old('valoare') }}"
                    required> 
            </div>
            <div class="form-group col-lg-3 mb-2"> 
                <label for="valoare_tva" class="mb-0 pl-3">Valoare TVA:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('valoare_tva') ? 'is-invalid' : '' }}" 
                    name="valoare_tva" 
                    placeholder="" 
                    value="{{ old('valoare_tva') == '' ? $facturi_produse->valoare_tva : old('valoare_tva') }}"
                    required> 
            </div>
        </div>
        
                                
        <div class="form-row mb-3 px-2 justify-content-center">                                    
            <div class="col-lg-8 d-flex justify-content-center">  
                <button type="submit" class="btn btn-primary btn-sm mr-2 rounded-pill">{{ $buttonText }}</button> 
                {{-- <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="{{ $clienti->path() }}">Renunță</a>  --}}
                <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="/facturi">Renunță</a> 
            </div>
        </div>
    </div>
</div>