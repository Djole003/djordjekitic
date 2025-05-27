@extends('layouts.app')
@include('partials.header')

@section('content')
<div class="container my-5 cart-container">
    <h1 class="cart-title">Vaša korpa</h1>

    @if(session('order') && count(session('order')) > 0)
        <table class="table cart-table mt-4">
            <thead class="cart-table-head">
                <tr>
                    <th>Proizvod</th>
                    <th>Količina</th>
                    <th>Cena po komadu</th>
                    <th>Ukupno</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @php $totalPrice = 0; @endphp
                @foreach(session('order') as $item)
                    <tr class="cart-item-row">
                        <td class="product-name">{{ \App\Models\Product::find($item['id'])->name ?? 'Nepoznat proizvod' }}</td>
                        <td class="product-qty">{{ $item['kolicina'] }}</td>
                        <td class="product-price">{{ number_format($item['cena'], 2) }} RSD</td>
                        <td class="product-total">{{ number_format($item['cena'] * $item['kolicina'], 2) }} RSD</td>
                        <td class="product-action">
                            <form method="POST" action="{{ route('order.remove', $item['id']) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger btn-remove">Ukloni</button>
                            </form>
                        </td>
                    </tr>
                    @php $totalPrice += $item['cena'] * $item['kolicina']; @endphp
                @endforeach
            </tbody>
            <tfoot class="cart-table-foot">
                <tr>
                    <th colspan="3" class="text-end total-label">Ukupno:</th>
                    <th class="total-price">{{ number_format($totalPrice, 2) }} RSD</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>

        <form action="{{ route('order.submit') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-success btn-confirm">Potvrdi porudžbinu</button>
        </form>


    @else
        <p class="empty-cart-text">Vaša korpa je prazna.</p>
    @endif
</div>
@include('partials.footer')
@endsection
