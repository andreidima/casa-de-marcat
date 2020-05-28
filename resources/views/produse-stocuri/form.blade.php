@csrf

<div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="form-group row px-2 py-2 mb-0">    
            <label for="produs_id" class="col-sm-4 col-form-label mb-0 pl-3">Produs:</label>                                   
            <div class="col-lg-8">  
                    <select name="produs_id" 
                        class="custom-select {{ $errors->has('produs_id') ? 'is-invalid' : '' }}"             
                        disabled
                    > 
                        <option                                 
                        value= {{ $produse_stocuri->produs_id }}                                       
                        > {{ $produse_stocuri->produs->nume }} </option>    
                    </select>
            </div> 
        </div>
        <div class="form-group row px-2 py-2 mb-0">          
            <label for="furnizor_id" class="col-sm-4 col-form-label mb-0 pl-3">Furnizor:</label>                                   
            <div class="col-lg-8">  
                    <select name="furnizor_id" 
                        class="custom-select {{ $errors->has('furnizor_id') ? 'is-invalid' : '' }}"   
                        disabled          
                    > 
                        <option                                 
                        value= {{ $produse_stocuri->furnizor_id }}                                       
                        > {{ $produse_stocuri->furnizor->nume }} </option>    
                    </select>
            </div> 
        </div>
        <div class="form-group row px-2 py-2 mb-0">          
            <label for="cantitate" class="col-sm-4 col-form-label mb-0 pl-3">Cantitate:</label>                                   
            <div class="col-lg-8">  
                <input type="number" min="1" max="9999999" 
                    class="form-control {{ $errors->has('cantitate') ? 'is-invalid' : '' }}" 
                    name="cantitate"
                    placeholder="Cantitate"                                        
                    value="{{ old('cantitate') == '' ? $produse_stocuri->cantitate : old('cantitate') }}"                                        
                    >
            </div> 
        </div>
        <div class="form-group row px-2 py-2 mb-0">          
            <label for="data" class="col-sm-4 col-form-label mb-0 pl-3">Data:</label>                                   
            <div class="col-lg-8">  
                <input type="text" 
                    class="form-control" 
                    name="data"
                    placeholder="Data"                                        
                    value="{{ \Carbon\Carbon::parse($produse_stocuri->created_at)->isoFormat('HH:mm - DD.MM.YYYY') ?? '' }}"    
                    disabled                                    
                    >
            </div> 
        </div>
        
                                
        <div class="form-row mb-3 px-2 justify-content-center">                                    
            <div class="col-lg-8 d-flex justify-content-center">  
                <button type="submit" class="btn btn-primary btn-sm mr-2 rounded-pill">{{ $buttonText }}</button> 
                {{-- <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="{{ $clienti->path() }}">Renunță</a>  --}}
                <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="/plati">Renunță</a> 
            </div>
        </div>
    </div>
</div>