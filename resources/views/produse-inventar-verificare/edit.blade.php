@extends ('layouts.app')

@section('content')   
    <div class="container card">
            <div class="row card-header">
                <div class="mt-2 mb-0">
                    <h4 class=""><i class="fas fa-boxes mr-1"></i>{{ $produse_inventar_verificare->produs->nume }}</h4>
                </div> 
            </div>
            <div class="card-body">
                <div class="row justify-content-around">
                    <div class="col-4 px-0"> 

                            @include('errors')

                            <form  class="needs-validation" novalidate method="POST" 
                                action="{{ $produse_inventar_verificare->path() }}"
                            >
                                @method('PATCH')
                                @csrf  

                                <div class="form-group row">
                                    <div class="col-6">
                                        <label for="cantitate" class="col-form-label">Cantitate:</label>
                                    </div>
                                    <div class="col-6 d-flex align-items-center">
                                        <input type="number" min="1" max="99999999"
                                            class="form-control form-control-sm border rounded-pill mb-0 py-0 {{ $errors->has('cantitate') ? 'is-invalid' : '' }}" 
                                            id="cantitate" 
                                            name="cantitate"
                                            placeholder="Cantitate"                                        
                                            value="{{ old('cantitate') == '' ? $produse_inventar_verificare->cantitate : old('cantitate') }}"
                                            autofocus
                                            autocomplete="off"
                                            >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12 d-flex justify-content-around">

                                        <button type="submit" class="btn btn-sm bg-primary text-white border border-dark rounded-pill">Modifică produsul</button>
                                    </div>
                                </div>  
                            </form>
                        </div>
                        
                    </div>
                </div>
            </div>
    </div>
@endsection