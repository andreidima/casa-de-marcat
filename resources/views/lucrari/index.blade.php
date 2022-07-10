@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;" id="modificari_globale_lucrari">
        <div class="row card-header justify-content-between py-1" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3 align-self-center">
                Lucrări
            </div>
            <div class="col-lg-6" id="">
                <form class="needs-validation" novalidate method="GET" action="{{ route('lucrari.index') }}">
                    @csrf
                    <div class="row input-group custom-search-form justify-content-center">
                        <div class="col-md-4 px-1">
                            <input type="text" class="form-control form-control-sm border rounded-pill mb-1 py-0"
                            id="search_categorie" name="search_categorie" placeholder="Categorie" autofocus
                                    value="{{ $search_categorie }}">
                        </div>
                        <div class="col-md-4 px-1">
                            <input type="text" class="form-control form-control-sm border rounded-pill mb-1 py-0"
                            id="search_producator" name="search_producator" placeholder="Producător" autofocus
                                    value="{{ $search_producator }}">
                        </div>
                        <div class="col-md-4 px-1">
                            <input type="text" class="form-control form-control-sm border rounded-pill mb-1 py-0"
                            id="search_model" name="search_model" placeholder="Model" autofocus
                                    value="{{ $search_model }}">
                        </div>
                        <div class="col-md-4 px-1">
                            <input type="text" class="form-control form-control-sm border rounded-pill mb-1 py-0"
                            id="search_problema" name="search_problema" placeholder="Problemă" autofocus
                                    value="{{ $search_problema }}">
                        </div>
                        <div class="col-md-4 px-1">
                            <button class="btn btn-sm btn-primary col-md-12 border border-dark rounded-pill" type="submit">
                                <i class="fas fa-search text-white mr-1"></i>Caută
                            </button>
                        </div>
                        <div class="col-md-4 px-1">
                            <a class="btn btn-sm bg-secondary text-white col-md-12 border border-dark rounded-pill" href="{{ route('lucrari.index') }}" role="button">
                                <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 text-right">
                <a class="btn btn-sm mb-1 bg-success text-white border border-dark rounded-pill col-md-8" href="{{ route('lucrari.create') }}" role="button">
                    <i class="fas fa-plus-square text-white mr-1"></i>Adaugă lucrare
                </a>
                <div>
                    <input class="btn btn-sm btn-primary rounded-pill" type="button" value="Modificări globale" v-on:click="modificari_globale = !modificari_globale">
                </div>
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @include ('errors')

            <div v-if="modificari_globale">
                <form class="needs-validation" novalidate method="GET" action="/ssm/salariati-modifica-selectati">
                    <script type="application/javascript">
                        modificariGlobale = @json(old('modificariGlobale') ?? false);
                    </script>
                    <div v-cloak v-if="modificari_globale" class="row justify-content-center">
                        <div class="col-lg-8 mb-2 rounded-3" style="background-color:lightcyan">
                            <div class="row justify-content-center">
                                <div class="col-md-12 d-flex">
                                    Se vor modifica toate lucrările din selecția curentă: {{ $lucrari_selectate_total }} lucrări
                                </div>
                                <div class="col-md-12 d-flex align-items-center justify-content-center">

                                    {{-- Daca validarea da eroare, se intoarce inapoi cu modificariGlobale=true, ca sa nu fie ascunse optiunile de modificari globale --}}
                                    <input
                                        type="hidden"
                                        name="modificariGlobale"
                                        value="true">


                                    <label for="procent_pret" class="mb-0 pr-2 ">Procent preț: </label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm rounded-3 {{ $errors->has('procent_pret') ? 'is-invalid' : '' }}"
                                        style="width: 70px"
                                        name="procent_pret"
                                        value="{{ old('procent_pret') }}">
                                </div>
                                <div class="col-md-12 mb-2 d-flex align-items-center justify-content-center">
                                    <span>Ex: „1.20” va crește prețul cu 20%</span>
                                </div>
                                <div class="col-lg-12 mb-2 d-flex align-items-center justify-content-center">
                                    <button class="btn btn-sm btn-primary text-white me-3 border border-dark rounded-pill" type="submit">
                                        Modifică toate lucrările selectate (<b>{{ $lucrari_selectate_total }}</b>)
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded">
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>#</th>
                            <th>Categorie</th>
                            <th>Producător</th>
                            <th>Model</th>
                            <th>Problema</th>
                            <th>Preț</th>
                            <th class="text-center">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lucrari as $lucrare)
                            <tr>
                                <td align="">
                                    {{ ($lucrari ->currentpage()-1) * $lucrari ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    {{ $lucrare->categorie }}
                                </td>
                                <td>
                                    {{ $lucrare->producator }}
                                </td>
                                <td>
                                    {{ $lucrare->model }}
                                </td>
                                <td>
                                    {{ $lucrare->problema }}
                                </td>
                                <td>
                                    {{ $lucrare->pret }}
                                </td>
                                <td class="d-flex justify-content-end">
                                    <a href="{{ $lucrare->path() }}/modifica"
                                        class="flex mr-1"
                                    >
                                        <span class="badge badge-primary">Modifică</span>
                                    </a>
                                    <div style="flex" class="">
                                        <a
                                            href="#"
                                            data-toggle="modal"
                                            data-target="#stergeLucrare{{ $lucrare->id }}"
                                            title="Șterge Lucrare"
                                            >
                                            <span class="badge badge-danger">Șterge</span>
                                        </a>
                                            <div class="modal fade text-dark" id="stergeLucrare{{ $lucrare->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title text-white" id="exampleModalLabel">Lucrare: <b>{{ $lucrare->nume }}</b></h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" style="text-align:left;">
                                                        Ești sigur ca vrei să ștergi Lucrarea?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>

                                                        <form method="POST" action="{{ $lucrare->path() }}">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button
                                                                type="submit"
                                                                class="btn btn-danger"
                                                                >
                                                                Șterge Lucrare
                                                            </button>
                                                        </form>

                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
                        @endforelse
                        </tbody>
                </table>
            </div>

                <nav>
                    <ul class="pagination pagination-sm justify-content-center">
                        {{ $lucrari->appends(Request::except('page'))->links() }}
                    </ul>
                </nav>

        </div>
    </div>
@endsection
