@extends('template.default')

@section('content')
    <div class="p-5">
        <h1 class="text-center">Edit Category</h1>
        <hr class="my-4">
        <div class="buttons">
            <a href="{{ route('app.category.index') }}" class="btn btn-secondary">Voltar</a>
        </div>
        <form action="{{ route('app.category.update', ['id' => $category['id']]) }}" method="POST" class="w-50 mx-auto">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="form-group">
                    <label for="title">Titulo: <span class="text-danger">*</span></label>
                    <input type="text" value="{{ old('title') ?? $category['title'] }}" name="title" id="title" placeholder="Title..." class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}">
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                </div>
            </div>
            <button class="d-block mx-auto btn btn-primary mt-4">Cadastrar</button>
        </form>
    </div>
@endsection