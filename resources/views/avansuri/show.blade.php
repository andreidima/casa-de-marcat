@extends ('layouts.app')

@section('content')   
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ml-4 my-0" style="color:white"><i class="fas fa-building mr-1"></i>Avansuri / {{ $avansuri->nume }}</h6>
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
                                    Nume
                                </td>
                                <td>
                                    {{ $avansuri->nume }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Descriere
                                </td>
                                <td>
                                    {{ $avansuri->descriere }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Suma
                                </td>
                                <td>
                                    {{ $avansuri->suma }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Card
                                </td>
                                <td>
                                    {{ $avansuri->card ? 'DA' : 'NU' }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Stare
                                </td>
                                <td>
                                    @if($avansuri->stare === 1)
                                        <p class='text-success m-0'><b>Deschis</b></p>
                                    @else
                                        Închis
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Data avans
                                </td>
                                <td>
                                    @isset($avansuri->contract_data)
                                        {{ \Carbon\Carbon::parse($contracte->contract_data)->isoFormat('HH:MM - DD.MM.YYYY') }}
                                    @endisset
                                </td>
                            </tr>
                        </table>
                    </div>                   
                                        
                    <div class="form-row mb-0 px-2 justify-content-center">                                    
                        <div class="col-lg-8 d-flex justify-content-center">  
                            <a class="btn btn-primary btn-sm mr-4 rounded-pill" href="/avansuri">Înapoi la Avansuri</a> 
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection