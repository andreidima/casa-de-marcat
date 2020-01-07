@extends ('layouts.app')

@section('content')   
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ml-4 my-0" style="color:white"><i class="fas fa-handshake mr-1"></i>Contracte / Nr. {{ $contracte->contract_nr }} - {{ $contracte->client->nume ?? '' }}</h6>
                </div>

                <div class="card-body py-2 border border-secondary" 
                    style="border-radius: 0px 0px 40px 40px;"
                    id="app1"
                >

            @if (session()->has('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif

                    <div class="table-responsive col-md-12 mx-auto">
                        <table class="table table-sm table-striped table-hover"
                                {{-- style="background-color:#008282" --}}
                        > 
                            <tr>
                                <td>
                                    Număr contract
                                </td>
                                <td>
                                    {{ $contracte->contract_nr }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Client
                                </td>
                                <td>
                                    {{ $contracte->client->nume ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Data contract
                                </td>
                                <td>
                                    @isset($contracte->contract_data)
                                        {{ \Carbon\Carbon::parse($contracte->contract_data)->isoFormat('D.MM.YYYY') }}
                                    @endisset
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Data începere
                                </td>
                                <td>
                                    @isset($contracte->data_incepere)
                                        {{ \Carbon\Carbon::parse($contracte->data_incepere)->isoFormat('D.MM.YYYY') }}
                                    @endisset
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Anexa
                                </td>
                                <td>
                                    @isset($contracte->anexa)
                                        <span class="badge badge-success">DA</span>
                                    @else
                                        <span class="badge badge-secondary">NU</span>
                                    @endisset
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    {!! $contracte->anexa !!}
                                </td>
                            </tr>
                        </table>
                    </div>
                                       
                    <div class="form-row mb-2 px-2">                                    
                        <div class="col-lg-12 d-flex justify-content-center">  
                            <a class="btn btn-primary btn-sm rounded-pill" href="/contracte">Pagină Contracte</a> 
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection