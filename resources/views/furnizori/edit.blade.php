@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">                     
                    <h6 class="ml-4 my-0" style="color:white"><i class="fas fa-store mr-1"></i>Schimbă datele furnizorului</h6>
                </div>
                
                @include ('errors')                

                <div class="card-body py-2 border border-secondary" 
                    style="border-radius: 0px 0px 40px 40px;"
                    id="app1"
                >
                    <form  class="needs-validation" novalidate method="POST" action="{{ $furnizori->path() }}">
                        @method('PATCH')
                            
                                
                                @include ('furnizori.form', [
                                    'buttonText' => 'Modifică Furnizor'
                                ])
                                
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection