@csrf

<div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="form-row px-2 py-2 mb-0">
            <div class="form-group col-lg-4 mb-2">
                <label for="categorie" class="mb-0 pl-3">Categorie:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('categorie') ? 'is-invalid' : '' }}"
                    name="categorie"
                    placeholder=""
                    value="{{ old('categorie', $lucrare->categorie) }}"
                    required>
            </div>
            <div class="form-group col-lg-4 mb-2">
                <label for="producator" class="mb-0 pl-3">Producător:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('producator') ? 'is-invalid' : '' }}"
                    name="producator"
                    placeholder=""
                    value="{{ old('producator', $lucrare->producator) }}"
                    required>
            </div>
            <div class="form-group col-lg-4 mb-2">
                <label for="model" class="mb-0 pl-3">Model:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('model') ? 'is-invalid' : '' }}"
                    name="model"
                    placeholder=""
                    value="{{ old('model', $lucrare->model) }}"
                    required>
            </div>
            <div class="form-group col-lg-10 mb-2">
                <label for="problema" class="mb-0 pl-3">Problema:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('problema') ? 'is-invalid' : '' }}"
                    name="problema"
                    placeholder=""
                    value="{{ old('problema', $lucrare->problema) }}"
                    required>
            </div>
            <div class="form-group col-lg-2 mb-2">
                <label for="pret" class="mb-0 pl-3">Preț:</label>
                <input
                    type="number"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('pret') ? 'is-invalid' : '' }}"
                    name="pret"
                    placeholder=""
                    value="{{ old('pret', $lucrare->pret) }}"
                    required>
            </div>
        </div>


        <div class="form-row mb-3 px-2 justify-content-center">
            <div class="col-lg-8 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-sm mr-2 rounded-pill">{{ $buttonText }}</button>
                <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="/lucrari">Renunță</a>
            </div>
        </div>
    </div>
</div>
