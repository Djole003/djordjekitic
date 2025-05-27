@extends('admin.layouts.app')
@include('partials.header')

@section('content')
<div class="container product-list-container mt-4">
    <h1 class="product-list-title">Lista proizvoda</h1>

    <a href="{{ route('admin.products.create') }}" class="btn btn-primary product-list-add-btn mb-3">Dodaj novi proizvod</a>

    @if(session('success'))
        <div class="alert alert-success product-list-alert-success">{{ session('success') }}</div>
    @endif

    @if($products->count() > 0)
    <table class="table product-list-table table-bordered table-striped">
        <thead class="product-list-thead">
            <tr>
                <th class="product-list-th">ID</th>
                <th class="product-list-th">Naziv</th>
                <th class="product-list-th">Cena</th>
                <th class="product-list-th">Kategorija</th>
                <th class="product-list-th">Slika</th>
                <th class="product-list-th">Akcije</th>
            </tr>
        </thead>
        <tbody class="product-list-tbody">
            @foreach($products as $product)
            <tr class="product-list-tr">
                <td class="product-list-td">{{ $product->id }}</td>
                <td class="product-list-td">{{ $product->name }}</td>
                <td class="product-list-td">{{ number_format($product->price, 2) }} RSD</td>
                <td class="product-list-td">{{ $product->category }}</td>
                <td class="product-list-td">
                    @if($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="product-list-img" width="70">
                    @else
                        Nema slike
                    @endif
                </td>
                <td class="product-list-td">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm product-list-btn-edit">Izmeni</a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm product-list-btn-delete"
                            onclick="return confirm('Da li ste sigurni da želite da obrišete proizvod?')">Obriši</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <p class="product-list-no-products">Nema unetih proizvoda.</p>
    @endif
</div>
@endsection
