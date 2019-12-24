@extends ('layouts.app')

@section('content')  

    <div class="container card">
            <div class="row card-header">
                <div class="mt-2 mb-0">
                    <h4 class=""><a href="/produse"><i class="fas fa-list-ul mr-1"></i>Produse</a> / {{ $produse->nume }}</h4>
                </div> 
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                        
                    @if (session()->has('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                
                    <div class="table-responsive col-md-7 mx-auto">
                        <table class="table table-striped table-hover table-dark"
                            style="background-color:#008282"
                        > 
                            <tr>
                                <td>
                                    Nume
                                </td>
                                <td>
                                    {{ $produse->nume }}
                                </td>
                            </tr>
                            </tr>
                                <td>
                                    Preț de achiziție
                                </td>
                                <td>
                                    {{ $produse->pret_de_achizitie }}
                                </td>
                            </tr>
                            </tr>
                                <td>
                                    Preț de vânzare
                                </td>
                                <td>
                                    {{ $produse->pret }}
                                </td>
                            </tr>
                            </tr>
                                <td>
                                    Cantitate
                                </td>
                                <td>
                                    {{ $produse->cantitate }}
                                </td>
                            </tr>
                            </tr>
                                <td>
                                    Cod de bare
                                </td>
                                <td>
                                    {{ $produse->cod_de_bare }}
                                </td>
                            </tr>
                            </tr>
                                <td>
                                    Localizare
                                </td>
                                <td>
                                    {{ $produse->localizare }}
                                </td>
                            </tr>
                            </tr>
                                <td>
                                    Descriere
                                </td>
                                <td>
                                    {{ $produse->descriere }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 justify-content-center d-flex">
                        <div class="mr-4">                           
                            <a href="/produse"
                                role="button"
                                class="btn btn-primary btn-lg"
                                target=""
                                title="Produse"
                                >
                                Produse
                            </a>
                        </div>
                        <div>                              
                            <a href="{{ $produse->path() }}/export/barcode-pdf"
                                role="button"
                                class="btn btn-success btn-lg"
                                target="_blank"
                                title="Printeaza barcode"
                                >
                                Barcode
                            </a>
                        </div>   
                    </div>
                </div>
            </div>
    </div>
@endsection
