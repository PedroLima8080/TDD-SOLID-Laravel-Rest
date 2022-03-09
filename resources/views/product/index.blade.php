@extends('template.main')

@section('content')
    <div class="px-5 mt-4">
        <div class="d-flex justify-content-center align-items-center">
            <a href="{{ route('app.home') }}" class="btn btn-secondary circle-button"><i class="fa-solid fa-chevron-left"></i></a>
            <h1 class="text-center me-auto ms-auto">Products</h1>
            <a href="{{ route('app.product.create') }}" class="btn btn-primary circle-button"><i class="fa-solid fa-plus"></i></a>
        </div>
        <hr class="my-4">
        <div class="buttons">
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product['id'] }}</td>
                            <td>{{ $product['title'] }}</td>
                            <td>{{ $product['description'] }}</td>
                            <td>{{ $product['quantity'] }}</td>
                            <td>{{ $product['price'] }}</td>
                            <td>{{ $product['category']['title'] }}</td>
                            <td class="d-flex w-100 justify-content-end">
                                <a href="{{ route('app.product.edit', $product['id']) }}" class="btn btn-primary me-2"><i class="fa-solid fa-pen"></i></a>
                                {{--
                                <form action="{{ route('app.category.destroy', ['id' => $category['id']]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                                </form>
                                --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection