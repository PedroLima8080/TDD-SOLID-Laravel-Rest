@extends('template.main')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    {{ $errors }}
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
                        <th>ALterar Quantidade</th>
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
                            <td>
                                <div class="d-flex">
                                    <button class="btn btn-secondary" type="button" onclick="changeQuantity('decrease', {{$product['id']}})">-</button>
                                    <input type="number" name="quantity" id="quantity" value='0' class="form-control" style="width: 100px">
                                    <button class="btn btn-secondary" type="button" onclick="changeQuantity('increase', {{$product['id']}})">+</button>
                                </div>
                            </td>
                            <td class="d-flex w-100 justify-content-end">
                                <a href="{{ route('app.product.edit', $product['id']) }}" class="btn btn-primary me-2"><i class="fa-solid fa-pen"></i></a>
                                <form action="{{ route('app.product.destroy', ['id' => $product['id']]) }}" method="post">
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

@push('scripts')
    <script>
        let form = document.getElementById('form')
        
        async function changeQuantity(action, id){
            let url = "{{ route('app.product.change_quantity', ['product' => ':idHere']) }}"
            url = url.replace(':idHere', id)

            let form = new FormData();
            form.append('quantity', document.getElementById('quantity').value);
            form.append('action', action);

            let response = await fetch(url, {
                method: 'POST', 
                body: form,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

            if(await response.status == 200)
                document.location.reload()
        }
    </script>
@endpush