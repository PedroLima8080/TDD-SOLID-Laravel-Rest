@extends('template.default')

@section('content')
<div class="min-vh-100 d-flex justify-content-center align-items-center">
    <div class="border py-4 px-5 rounded form">
        <h1 class="text-center">Registre-se Aqui</h1>
        <hr class="my-3">
        <form action="{{ route('auth.register') }}" method="POST">
            @csrf
            <div class="row">
                <div class="form-group mb-3 col-md-6">
                    <label for="name">Name: <span class="text-danger">*</span></label>
                    <input value="{{ old('name') ?? '' }}" type="text" id="name" name="name" placeholder="Your name..." class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}">
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                </div>
                <div class="form-group mb-3 col-md-6">
                    <label for="email">Email: <span class="text-danger">*</span></label>
                    <input value="{{ old('email') ?? '' }}" type="text" id="email" name="email" placeholder="Your email..." class="form-control  {{ $errors->has('email') ? 'is-invalid' : '' }}">
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group mb-3 col-md-6">
                    <label for="password">Password <span class="text-danger">*</span></label>
                    <input class="form-control  {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password" placeholder="Your password...">
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                </div>
                <div class="form-group mb-3 col-md-6">
                    <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                    <input class="form-control  {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm password...">
                    <div class="invalid-feedback">
                        {{ $errors->first('password_confirmation') }}
                    </div>
                </div>
            </div>
            <div class="links">
                <a href="{{ route('auth.login') }}">Já possui uma conta?</a>
            </div>
            <div class="d-flex justify-content-center mt-2">
                <button class="btn btn-primary">Registrar</button>
            </div>
        </form>
    </div>
</div>
@endsection