@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{  $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session()->has('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@elseif (session()->has('eroare'))
    <div class="alert alert-danger">
        {{ session('eroare') }}
    </div>
@endif