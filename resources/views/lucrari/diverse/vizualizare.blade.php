@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ml-4 my-0" style="color:white">Lucrări - vizualizare</h6>
                </div>

                    <div class="card-body py-3" id="lucrari_vizualizare">

                        @include ('errors')

                        <script type="application/javascript">
                            lucrari={!! json_encode($lucrari) !!}
                        </script>

                        <div class="row">
                            <div class="col-lg-12 mb-4">
                                <button v-cloak v-if="categorieSelectata" v-on:click="categorieSelectata = ''" class="btn btn-success">
                                    1. Categorie:
                                    <br>
                                    @{{ categorieSelectata }}
                                </button>
                                <button v-else class="text-dark" disabled>
                                    1. Categorie
                                </button>
                                <button v-cloak v-if="producatorSelectat" v-on:click="producatorSelectat = ''" class="btn btn-success">
                                    2. Producător:
                                    <br>
                                    @{{ producatorSelectat }}
                                </button>
                                <button v-else class="text-dark" disabled>
                                    2. Producător
                                </button>
                                <button v-cloak v-if="modelSelectat" v-on:click="modelSelectat = ''" class="btn btn-success">
                                    3. Model:
                                    <br>
                                    @{{ modelSelectat }}
                                </button>
                                <button v-else class="text-dark" disabled>
                                    3. Model
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div v-if="categorieSelectata == ''" class="col-lg-12 d-flex">
                                @foreach ($lucrari->groupBy('categorie') as $lucrari_per_categorie)
                                    <button v-on:click="categorieSelectata = '{{ $lucrari_per_categorie->first()->categorie }}'">
                                    {{ $lucrari_per_categorie->first()->categorie }}
                                    </button>
                                @endforeach
                            </div>
                            <div v-else>
                                <div v-if="producatorSelectat == ''" class="col-lg-12 d-flex">
                                        <button v-for="producator in producatoriSelectati"
                                            v-on:click="producatorSelectat = producator"
                                        >
                                            @{{ producator }}
                                        </button>
                                </div>
                                <div v-else>
                                    <div v-if="modelSelectat == ''" class="col-lg-12 d-flex">
                                            <button v-for="model in modeleSelectate"
                                                v-on:click="modelSelectat = model"
                                            >
                                                @{{ model }}
                                            </button>
                                    </div>
                                    <div v-else>
                                    </div>
                            </div>
                        </div>

                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
