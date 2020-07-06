@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">                     
                    <h6 class="ml-4 my-0" style="color:white"><i class="fas fa-file-invoice mr-1"></i>Generează factură</h6>
                </div>
                
                @include ('errors')                

                <div class="card-body py-2 border border-secondary" 
                    style="border-radius: 0px 0px 40px 40px;"
                    id="generare-factura"
                >
                    <form  class="needs-validation" novalidate method="POST" 
                                action="{{ action('GenereazaFacturaClientController@salvareDate') }}"
                    >        
                        @csrf             
                
                        <div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px">
                            <div class="form-group col-lg-12 px-2 mb-0">
                                <div class="form-row px-2 py-2 mb-0">    
                                    <div class="form-group col-lg-12 mb-2"> 
                                        {{-- <div class="form-group row"> --}}
                                            <label for="client_deja_inregistrat" class="mb-0 pl-3">Selectează clientul dacă este deja înregistrat:</label>
                                            <div class="">    
                                                <script type="application/javascript"> 
                                                    clientVechi={!! json_encode(old('client_deja_inregistrat', ($client ?? ""))) !!}
                                                    clientVechiFirma={!! json_encode(old('firma', '')) !!}
                                                    clientVechiNr_reg_com={!! json_encode(old('nr_reg_com', '')) !!}
                                                    clientVechiCif_cnp={!! json_encode(old('cif_cnp', '')) !!}
                                                    clientVechiAdresa={!! json_encode(old('adresa', '')) !!}
                                                    clientVechiDelegat={!! json_encode(old('delegat', '')) !!}
                                                    clientVechiSeria_nr_buletin={!! json_encode(old('seria_nr_buletin', '')) !!}
                                                    clientVechiTelefon={!! json_encode(old('telefon', '')) !!}
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
                                                                {{-- @if(old('client_deja_inregistrat') !== null)
                                                                    @if ($client->id == old('client_deja_inregistrat'))
                                                                        selected
                                                                    @endif
                                                                @endif --}}
                                                        >{{ $client->firma }} </option>                                                
                                                    @endforeach
                                                </select>
                                            </div>
                                        {{-- </div>  --}}
                                    </div>
                                    <div class="form-group col-lg-12 mb-2"> 
                                        <label for="firma" class="mb-0 pl-3">Firma:</label>                                      
                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm rounded-pill {{ $errors->has('firma') ? 'is-invalid' : '' }}" 
                                            name="firma" 
                                            placeholder="" 
                                            v-model="client_firma"
                                            {{-- value="{{ old('firma') == '' ? $plati->firma : old('firma') }}" --}}
                                            required> 
                                    </div>                           
                                    <div class="form-group col-lg-6 mb-2">  
                                        <label for="nr_reg_com" class="mb-0 pl-3">Nr. Reg. com.:</label>                               
                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm rounded-pill {{ $errors->has('nr_reg_com') ? 'is-invalid' : '' }}" 
                                            name="nr_reg_com" 
                                            placeholder="" 
                                            v-model="client_nr_reg_com"
                                            {{-- value="{{ old('nr_reg_com') == '' ? $plati->nr_reg_com : old('nr_reg_com') }}" --}}
                                            required> 
                                    </div>                             
                                    <div class="form-group col-lg-6 mb-2">  
                                        <label for="cif_cnp" class="mb-0 pl-3">CIF/CNP:</label>                               
                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm rounded-pill {{ $errors->has('cif_cnp') ? 'is-invalid' : '' }}" 
                                            name="cif_cnp" 
                                            placeholder=""
                                            v-model="client_cif_cnp" 
                                            {{-- value="{{ old('cif_cnp') == '' ? $plati->cif_cnp : old('cif_cnp') }}" --}}
                                            required> 
                                    </div>                           
                                    <div class="form-group col-lg-12 mb-2">  
                                        <label for="adresa" class="mb-0 pl-3">Adresa:</label>                               
                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm rounded-pill {{ $errors->has('adresa') ? 'is-invalid' : '' }}" 
                                            name="adresa" 
                                            placeholder=""
                                            v-model="client_adresa" 
                                            {{-- value="{{ old('adresa') == '' ? $plati->adresa : old('adresa') }}" --}}
                                            required> 
                                    </div>                                                     
                                    <div class="form-group col-lg-12 mb-2">  
                                        <label for="delegat" class="mb-0 pl-3">Delegat:</label>                               
                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm rounded-pill {{ $errors->has('delegat') ? 'is-invalid' : '' }}" 
                                            name="delegat" 
                                            placeholder=""
                                            v-model="client_delegat" 
                                            {{-- value="{{ old('delegat') == '' ? $plati->delegat : old('delegat') }}" --}}
                                            required> 
                                    </div>                                                   
                                    <div class="form-group col-lg-6 mb-2">  
                                        <label for="seria_nr_buletin" class="mb-0 pl-3">Seria nr buletin:</label>                               
                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm rounded-pill {{ $errors->has('seria_nr_buletin') ? 'is-invalid' : '' }}" 
                                            name="seria_nr_buletin" 
                                            placeholder=""
                                            v-model="client_seria_nr_buletin" 
                                            {{-- value="{{ old('seria_nr_buletin') == '' ? $plati->seria_nr_buletin : old('seria_nr_buletin') }}" --}}
                                            required> 
                                    </div>
                                    <div class="form-group col-lg-6 mb-4">  
                                        <label for="telefon" class="mb-0 pl-3">Telefon:</label>                               
                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm rounded-pill {{ $errors->has('telefon') ? 'is-invalid' : '' }}" 
                                            name="telefon" 
                                            placeholder=""
                                            v-model="client_telefon" 
                                            {{-- value="{{ old('telefon') == '' ? $plati->telefon : old('telefon') }}" --}}
                                            required> 
                                    </div>
                                </div>
                                

                                <div class="col-lg-8 card px-0 mb-4 mx-auto">
                                    <div class="card-header text-center p-0">
                                        Produse de facturat:
                                    </div>    
                                    <div class="card-body p-0"> 
                                            <div class="alert alert-success text-center p-0 mb-0">
                                                @php 
                                                    $total_suma = 0;
                                                @endphp
                                                @forelse ($produse_vandute as $produs)
                                                    {{ $produs['cantitate'] }} buc. {{ $produs['nume'] }} - {{ $produs['pret'] }} lei
                                                    <br>
                                                    @php
                                                        $total_suma += $produs['pret'];
                                                    @endphp
                                                @empty
                                                    Factura nu conține produse atașate
                                                @endforelse
                                            </div>
                                    </div>
                                    <div class="card-header text-right p-0">
                                        Total: <b>{{ $total_suma }}</b> lei
                                    </div> 
                                </div>
                                
                                                        
                                <div class="form-row mb-3 px-2 justify-content-center">                                    
                                    <div class="col-lg-8 d-flex justify-content-center">  
                                        <button type="submit" class="btn btn-primary btn-sm mr-2 rounded-pill">Generează factura</button> 
                                        {{-- <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="{{ $clienti->path() }}">Renunță</a>  --}}
                                        <a class="btn btn-secondary btn-sm rounded-pill" href="/produse/vanzari">Renunță</a> 
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection