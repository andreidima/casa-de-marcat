@extends ('layouts.app')

@section('content')  

    <div class="container card">
            <div class="row card-header">
                <div class="mt-2 mb-0">
                    <h4 class=""><i class="fas fa-list-ul mr-1"></i>Gestiune</h4>
                </div> 
            </div>
            <div class="card-body">
                <div class="row d-flex">
                        
                    @if (session()->has('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                @foreach ($gestiune as $categorie)
                    <div class="col-sm-3 mb-2" style="font-size: 1.3em">
                        <p class="d-inline">
                            <span class="badge badge-dark"
                                 style="background-color:darkcyan;"
                            >
                                {{ $categorie->nume }}
                                {{ number_format($categorie->pret,0) }} lei = 
                                <span class="badge text-white m-0" style="background-color:#e66800; font-size: 1em;">
                                    {{ $categorie->cantitate }}
                                </span>
                            </span>
                        </p>
                    </div>
                @endforeach
                </div>

            </div>
    </div>
@endsection
