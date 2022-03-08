@extends('template.default')

@section('content')
    <div class="p-5">
        <h1 class="text-center">Home</h1>
        <hr class="my-4">
        <div class="system-informations">
            
        </div>
        <div class="user-informations">
            <h5>
                Welcome, {{ Auth::user()->name }}
            </h5>
        </div>
        <div class="links">
            <ul>
                <li><a href="{{ route('app.category.index') }}">Categorias</a></li>
            </ul>
        </div>
    </div>
@endsection