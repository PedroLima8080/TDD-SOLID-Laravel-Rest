@extends('template.main')

@section('content')
    <div class="px-5 mt-4">
        <div class="d-flex justify-content-center align-items-center">
            <a href="{{ route('app.category.index') }}" class="btn btn-secondary circle-button"><i class="fa-solid fa-chevron-left"></i></a>
            <h1 class="text-center me-auto ms-auto">Create Category</h1>
        </div>
        <hr class="my-4">
        <form action="{{ route('app.category.store') }}" method="POST" class="w-50 mx-auto">
            @csrf
            <div class="row">
                <div class="form-group">
                    <label for="title">Titulo: <span class="text-danger">*</span></label>
                    <input type="text" value="{{ old('title') }}" name="title" id="title" placeholder="Title..." class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}">
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                </div>
            </div>
            <button class="d-block mx-auto btn btn-primary mt-4">Cadastrar</button>
        </form>
    </div>
@endsection