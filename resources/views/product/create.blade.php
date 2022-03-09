@extends('template.main')

@section('content')
    <div class="px-5 mt-4">
        <h1 class="text-center">Create Product</h1>
        <hr class="my-4">
        <div class="buttons">
            <a href="{{ route('app.product.index') }}" class="btn btn-secondary">Voltar</a>
        </div>
        <form action="{{ route('app.product.store') }}" method="POST" class="w-50 mx-auto">
            @csrf
            <div class="row">
                <div class="form-group mb-3 col-md-6">
                    <label for="title">Title: <span class="text-danger">*</span></label>
                    <input type="text" value="{{ old('title') }}" name="title" id="title" placeholder="Title..." class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}">
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                </div>
                <div class="form-group mb-3 col-md-6">
                    <label for="price">Price: <span class="text-danger">*</span></label>
                    <input type="text" value="{{ old('price') }}" name="price" id="price" placeholder="Price..." class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}">
                    <div class="invalid-feedback">
                        {{ $errors->first('price') }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group mb-3 col-md-6">
                    <label for="category_id">Category: <span class="text-danger">*</span></label>
                    <select name="category_id" id="category_id" class="form-control {{ $errors->has('category_id') ? 'is-invalid' : '' }}">
                        <option value="">--Selecione--</option>
                        @foreach ($categories as $category)
                            <option {{ old('category_id') == $category->id ? 'selected' : '' }} value="{{$category->id}}">{{$category->title}}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        {{ $errors->first('category_id') }}
                    </div>
                </div>
                <div class="form-group mb-3 col-md-6">
                    <label for="price">Quantity: <span class="text-danger">*</span></label>
                    <input type="text" value="{{ old('quantity') }}" name="quantity" id="quantity" placeholder="Quantity..." class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}">
                    <div class="invalid-feedback">
                        {{ $errors->first('quantity') }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group mb-3 col-md-12">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" placeholder="Description..." class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description') }}</textarea>
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                </div>
            </div>
            <button class="d-block mx-auto btn btn-primary mt-4">Create</button>
        </form>
    </div>
@endsection