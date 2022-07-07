@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ml-4 my-0" style="color:white">Lucrări - vizualizare</h6>
                </div>

                    <div class="card-body py-3" id="lucrari_vizualizare" style="background-color:rgb(243, 241, 241)">

                        @include ('errors')

                        <script type="application/javascript">
                            lucrari={!! json_encode($lucrari) !!}
                        </script>

                        <div class="row justify-content-center mb-4">
                            <div v-cloak v-if="categorieSelectata" class="col-lg-2">
                                <button v-on:click="categorieSelectata = ''" class="btn btn-light shadow-sm btn btn-block">
                                    1. Categorie:
                                    <br>
                                    @{{ categorieSelectata }}
                                </button>
                            </div>
                            <div v-else class="col-lg-2">
                                <button class="text-dark btn btn-block" disabled>
                                    1. Categorie
                                </button>
                            </div>

                            <div v-cloak v-if="producatorSelectat" class="col-lg-2">
                                <button v-on:click="producatorSelectat = ''" class="btn btn-light shadow-sm btn btn-block">
                                    2. Producător:
                                    <br>
                                    @{{ producatorSelectat }}
                                </button>
                            </div>
                            <div v-else class="col-lg-2">
                                <button class="text-dark btn btn-block" disabled>
                                    2. Producător
                                </button>
                            </div>

                            <div v-cloak v-if="modelSelectat" class="col-lg-2">
                                <button v-on:click="modelSelectat = ''" class="btn btn-light shadow-sm btn btn-block">
                                    3. Model:
                                    <br>
                                    @{{ modelSelectat }}
                                </button>
                            </div>
                            <div v-else class="col-lg-2">
                                <button class="text-dark btn btn-block" disabled>
                                    3. Model
                                </button>
                            </div>

                            <div v-cloak v-if="pretTotal != 0" class="col-lg-2">
                                <button class="btn btn-light text-dark border border-danger border-4 btn btn-block" disabled>
                                    4. Preț total:
                                    <br>
                                    <h3 class="text-danger"><b>@{{ pretTotal }} lei</b></h3>
                                </button>
                            </div>
                            <div v-else class="col-lg-2">
                                <button class="text-dark btn btn-block" disabled>
                                    4. Preț total
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div v-cloak v-if="categorieSelectata == ''" class="col-lg-12">
                                <h5>
                                    Selectează categoria:
                                </h5>
                                <div class="row">
                                    @foreach ($lucrari->groupBy('categorie') as $lucrari_per_categorie)
                                        <div class="col-lg-2 mb-3">
                                            <button v-on:click="categorieSelectata = '{{ $lucrari_per_categorie->first()->categorie }}'" class="btn btn-light shadow-sm btn btn-block">
                                            {{ $lucrari_per_categorie->first()->categorie }}
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div v-else class="col-lg-12">
                                <div v-cloak v-if="producatorSelectat == ''" class="row">
                                    <div class="col-lg-12">
                                        <h5>
                                            Selectează producătorul:
                                        </h5>
                                    </div>
                                    <div v-for="producator in producatoriSelectati" class="col-lg-2 mb-3">
                                        <button class="btn btn-light shadow-sm btn btn-block"
                                            v-on:click="producatorSelectat = producator"
                                        >
                                            @{{ producator }}
                                        </button>
                                    </div>
                                </div>
                                <div v-else class="col-lg-12">
                                    <div v-cloak v-if="modelSelectat == ''" class="row">
                                        <div class="col-lg-12">
                                            <h5>
                                                Selectează modelul:
                                            </h5>
                                        </div>
                                        <div v-for="model in modeleSelectate" class="col-lg-2 mb-3">
                                            <button v-on:click="modelSelectat = model" class="btn btn-light shadow-sm btn btn-block">
                                                @{{ model }}
                                            </button>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h5>
                                                    Selectează problemele:
                                                </h5>
                                            </div>
                                            <div v-for="lucrare in lucrariSelectate" class="col-lg-6 mb-2 rounded-pill">
                                                <div class="custom-control custom-checkbox border border-4" style="padding-left:30px; display: inline-block; border-color:mediumseagreen;">
                                                    <input type="checkbox"
                                                        class="custom-control-input"
                                                        name="lucrariBifate[]"
                                                        v-model="lucrariBifate"
                                                        :value="lucrare.id"
                                                        style="padding:20px"
                                                        :id="lucrare.id"
                                                        number
                                                        >
                                                    {{-- <label class="custom-control-label text-white px-1" :for="lucrare.id" style="background-color:mediumseagreen;"> --}}
                                                    <label class="custom-control-label px-1" :for="lucrare.id" style="background-color:white;">
                                                        @{{ lucrare.problema }} = @{{ lucrare.pret }} lei
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>

                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
