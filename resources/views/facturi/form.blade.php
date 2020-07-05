@csrf

<div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="form-row px-2 py-2 mb-0">    
            <div class="form-group col-lg-12 mb-2"> 
                    <label for="client_deja_inregistrat" class="mb-0 pl-3">Selectează clientul dacă este deja înregistrat:</label>
                    <div class="">    
                        <script type="application/javascript"> 
                            clientVechi={!! json_encode(old('client_deja_inregistrat', ($facturi->client_id ?? ""))) !!}
                            clientiExistenti={!! json_encode($clienti) !!}
                        </script>                                     
                        <select name="client_deja_inregistrat" 
                            class="custom-select custom-select-sm rounded-pill {{ $errors->has('client_deja_inregistrat') ? 'is-invalid' : '' }}" 
                            v-model="client_deja_inregistrat"  
                            @change="getDateClient()"
                        >
                                <option value='' selected>Selectează client</option>
                            @foreach ($clienti as $client)                           
                                <option 
                                    value='{{ $client->id }}'
                                >{{ $client->firma }} </option>                                                
                            @endforeach
                        </select>
                    </div>
            </div>
            <div class="form-group col-lg-12 mb-2"> 
                <script type="application/javascript"> 
                    clientVechiFirma={!! json_encode(old('firma', $facturi->firma)) !!}
                </script>   
                <label for="firma" class="mb-0 pl-3">Firma:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('firma') ? 'is-invalid' : '' }}" 
                    name="firma" 
                    placeholder="" 
                    v-model="client_firma"
                    value="{{ old('firma') == '' ? $facturi->firma : old('firma') }}"
                    required> 
            </div>                           
            <div class="form-group col-lg-6 mb-2">  
                <script type="application/javascript"> 
                    clientVechiNr_reg_com={!! json_encode(old('nr_reg_com', $facturi->nr_reg_com)) !!}
                </script>  
                <label for="nr_reg_com" class="mb-0 pl-3">Nr. Reg. com.:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nr_reg_com') ? 'is-invalid' : '' }}" 
                    name="nr_reg_com" 
                    placeholder="" 
                    v-model="client_nr_reg_com"
                    value="{{ old('nr_reg_com') == '' ? $facturi->nr_reg_com : old('nr_reg_com') }}"
                    required> 
            </div>                             
            <div class="form-group col-lg-6 mb-2">  
                <script type="application/javascript"> 
                    clientVechiCif_cnp={!! json_encode(old('cif_cnp', $facturi->cif_cnp)) !!}
                </script>  
                <label for="cif_cnp" class="mb-0 pl-3">CIF/CNP:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('cif_cnp') ? 'is-invalid' : '' }}" 
                    name="cif_cnp" 
                    placeholder=""
                    v-model="client_cif_cnp" 
                    value="{{ old('cif_cnp') == '' ? $facturi->cif_cnp : old('cif_cnp') }}"
                    required> 
            </div>                           
            <div class="form-group col-lg-12 mb-2">  
                <script type="application/javascript"> 
                    clientVechiAdresa={!! json_encode(old('adresa', $facturi->adresa)) !!}
                </script>  
                <label for="adresa" class="mb-0 pl-3">Adresa:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('adresa') ? 'is-invalid' : '' }}" 
                    name="adresa" 
                    placeholder=""
                    v-model="client_adresa" 
                    value="{{ old('adresa') == '' ? $facturi->adresa : old('adresa') }}"
                    required> 
            </div>                                                     
            <div class="form-group col-lg-12 mb-2">  
                <script type="application/javascript"> 
                    clientVechiDelegat={!! json_encode(old('delegat', $facturi->delegat)) !!}
                </script>  
                <label for="delegat" class="mb-0 pl-3">Delegat:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('delegat') ? 'is-invalid' : '' }}" 
                    name="delegat" 
                    placeholder=""
                    v-model="client_delegat" 
                    value="{{ old('delegat') == '' ? $facturi->delegat : old('delegat') }}"
                    required> 
            </div>                                                   
            <div class="form-group col-lg-6 mb-2">  
                <script type="application/javascript"> 
                    clientVechiSeria_nr_buletin={!! json_encode(old('seria_nr_buletin', $facturi->seria_nr_buletin)) !!}
                </script>  
                <label for="seria_nr_buletin" class="mb-0 pl-3">Seria nr buletin:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('seria_nr_buletin') ? 'is-invalid' : '' }}" 
                    name="seria_nr_buletin" 
                    placeholder=""
                    v-model="client_seria_nr_buletin" 
                    value="{{ old('seria_nr_buletin') == '' ? $facturi->seria_nr_buletin : old('seria_nr_buletin') }}"
                    required> 
            </div>
            <div class="form-group col-lg-6 mb-4">  
                <script type="application/javascript"> 
                    clientVechiTelefon={!! json_encode(old('telefon', $facturi->telefon)) !!}
                </script>  
                <label for="telefon" class="mb-0 pl-3">Telefon:</label>                               
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('telefon') ? 'is-invalid' : '' }}" 
                    name="telefon" 
                    placeholder=""
                    v-model="client_telefon" 
                    value="{{ old('telefon') == '' ? $facturi->telefon : old('telefon') }}"
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