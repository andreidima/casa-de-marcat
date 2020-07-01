@extends ('layouts.app')

@section('content')   
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ml-4 my-0" style="color:white"><i class="fas fa-money-bill-wave mr-1"></i>Clienți / {{ $clienti->nume }}</h6>
                </div>

                <div class="card-body py-2 border border-secondary" 
                    style="border-radius: 0px 0px 40px 40px;"
                    id="app1"
                >

            @include ('errors')

                    <div class="table-responsive col-md-12 mx-auto">
                        <table class="table table-sm table-striped table-hover"
                                {{-- style="background-color:#008282" --}}
                        > 
                            <tr>
                                <td>
                                    Firma
                                </td>
                                <td>
                                    {{ $clienti->firma }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Nr. reg. com.
                                </td>
                                <td>
                                    {{ $clienti->nr_reg_com }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Cif/ Cnp
                                </td>
                                <td>
                                    {{ $clienti->cif_cnp }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Adresa
                                </td>
                                <td>
                                    {{ $clienti->adresa }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Delegat
                                </td>
                                <td>
                                    {{ $clienti->delegat }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Buletin
                                </td>
                                <td>
                                    {{ $clienti->seria_nr_buletin }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Telefon
                                </td>
                                <td>
                                    {{ $clienti->telefon }}
                                </td>
                            </tr>
                        </table>
                    </div>                   
                                        
                    <div class="form-row mb-0 px-2 justify-content-center">                                    
                        <div class="col-lg-8 d-flex justify-content-center">  
                            <a class="btn btn-primary btn-sm mr-4 rounded-pill" href="/clienti">Înapoi la clienți</a> 
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection