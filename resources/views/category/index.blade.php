@extends('template.default')

@section('content')
    <div class="p-5">
        <h1 class="text-center">Categorias</h1>
        <hr class="my-4">
        <div class="buttons">
            <a href="{{ route('app.home') }}" class="btn btn-secondary">Voltar</a>
            <a href="{{ route('app.category.create') }}" class="btn btn-primary">Add Category</a>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category['id'] }}</td>
                            <td>{{ $category['title'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection