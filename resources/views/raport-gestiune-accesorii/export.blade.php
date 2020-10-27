@extends ('layouts.app')

@section('content')   
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header justify-content-between py-1" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3 align-self-center">
                <h4 class=" mb-0">
                    Raport gestiune accesorii
                </h4>
            </div> 
            <div class="col-lg-3 text-right">
            </div> 
        </div>

        <div class="card-body px-0 py-3">

            <div class="row justify-content-center">
                <div class="col-lg-3" id="app1">
                    <form class="needs-validation" novalidate method="GET" action="raport-gestiune-accesorii/export/raport-html">
                        @csrf                    
                        <div class="row input-group custom-search-form justify-content-center">                        
                            <div class="col-md-12 d-flex mb-3 justify-content-center">
                                <label for="search_data" class="mb-0 align-self-center mr-1">Data:</label>
                                <vue2-datepicker
                                    data-veche="{{ $search_data }}"
                                    nume-camp-db="search_data"
                                    tip="date"
                                    latime="100"
                                >
                            </div>
                            <div class="col-md-12 d-flex px-1 justify-content-center"> 
                                
                                {{-- <a href="/niruri/{{ \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') }}/raport-pdf"
                                    class="btn btn-sm btn-success mx-1 border border-dark rounded-pill"
                                    type="submit"
                                >
                                    <i class="fas fa-file-pdf mr-1"></i>Export PDF
                                </a> --}}
                                <button class="btn btn-success border border-dark rounded-pill" type="submit">
                                    <i class="fas fa-file-pdf mr-1"></i>Export PDF
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>

@endsection