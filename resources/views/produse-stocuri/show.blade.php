@extends ('layouts.app')

@section('content')   
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ml-4 my-0" style="color:white"><i class="fas fa-list-ul mr-1"></i>Produse - stocuri</h6>
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
                                    Produs
                                </td>
                                <td>
                                    {{ $produse_stocuri->produs->nume ?? ''}}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Furnizor
                                </td>
                                <td>
                                    {{ $produse_stocuri->furnizor->nume ?? ''}}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Nr. factură
                                </td>
                                <td>
                                    {{ $produse_stocuri->nr_factura }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Preț de achiziție
                                </td>
                                <td>
                                    {{ $produse_stocuri->pret_de_achizitie }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Cantitate
                                </td>
                                <td>
                                    {{ $produse_stocuri->cantitate }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Adăugare la nir
                                </td>
                                <td>
                                    {{ ($produse_stocuri->fara_nir === 0) ? 'DA' : 'NU' }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Data adăugării
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($produse_stocuri->created_at)->isoFormat('HH:MM - DD.MM.YYYY') }}
                                </td>
                            </tr>
                        </table>
                    </div>                   
                                        
                    <div class="form-row mb-0 px-2 justify-content-center">                                    
                        <div class="col-lg-8 d-flex justify-content-center">  
                            <a class="btn btn-primary btn-sm mr-4 rounded-pill" href="/produse-stocuri">Înapoi la Produse-Stocuri</a> 
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection