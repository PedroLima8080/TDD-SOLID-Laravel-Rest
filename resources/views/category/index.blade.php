@extends('template.main')

@section('content')
    <div class="px-5 mt-4">
        <div class="d-flex justify-content-center align-items-center">
            <a href="{{ route('app.home') }}" class="btn btn-secondary circle-button"><i class="fa-solid fa-chevron-left"></i></a>
            <h1 class="text-center me-auto ms-auto">Categorias</h1>
            <a href="{{ route('app.category.create') }}" class="btn btn-primary circle-button"><i class="fa-solid fa-plus"></i></a>
        </div>
        <hr class="my-4">
        <div class="buttons">
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Qty. Products</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category['id'] }}</td>
                            <td>{{ $category['title'] }}</td>
                            <td>{{ count($category['products']) }}</td>
                            <td class="d-flex w-100 justify-content-end">
                                <a href="{{ route('app.category.edit', $category['id']) }}" class="btn btn-primary me-2"><i class="fa-solid fa-pen"></i></a>
                                <form action="{{ route('app.category.destroy', ['id' => $category['id']]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection