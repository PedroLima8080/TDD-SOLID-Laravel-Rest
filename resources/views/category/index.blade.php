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
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category['id'] }}</td>
                            <td>{{ $category['title'] }}</td>
                            <td style="width: 220px">
                                <form action="{{ route('app.category.destroy', ['id' => $category['id']]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Remove Category</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection