@extends('template.default')

@section('content')
<div class="min-vh-100 d-flex justify-content-center align-items-center">
    <div class="border py-4 px-5 rounded form w-50">
        <h1 class="text-center">Faça Login</h1>
        <hr class="my-3">

        @if ($errors->has('message'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert" id="alert1">
            <strong>OPS!</strong> {{ $errors->first('message') }}
            <button type="button" class="btn-close" onclick="document.getElementById('alert1').remove()"></button>
          </div>
        @endif

        <form action="{{ route('auth.login') }}" method="POST">
            @csrf
            <div class="row">
                <div class="form-group mb-3 col-md-12">
                    <label for="email">Email: <span class="text-danger">*</span></label>
                    <input value="{{ old('email') }}" type="text" id="email" name="email" placeholder="Your email..." class="form-control  {{ $errors->has('email') ? 'is-invalid' : '' }}">
                </div>
            </div>
            <div class="row">
                <div class="form-group mb-3 col-md-12">
                    <label for="password">Password <span class="text-danger">*</span></label>
                    <input class="form-control  {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password" placeholder="Your password...">
                </div>
            </div>
            <div class="links">
                <a href="{{ route('auth.register') }}">Não possui uma conta?</a>
            </div>
            <div class="d-flex justify-content-center mt-2">
                <button class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
</div>
@endsection