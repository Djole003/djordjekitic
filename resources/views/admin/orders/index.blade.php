@extends('admin.layouts.app')
@include('partials.header')
@section('content')
<div class="container mt-4">
    <h1 class="order-index-title">Sve narudžbine</h1>

    @if(session('success'))
        <div class="alert alert-success order-index-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered order-index-table">
        <thead class="order-index-thead">
            <tr>
                <th>ID</th>
                <th>Korisnik</th>
                <th>Ukupno</th>
                <th>Status</th>
                <th>Datum</th>
                <th>Akcije</th>
            </tr>
        </thead>
        <tbody class="order-index-tbody">
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name ?? 'Nepoznato' }}</td>
                    <td>{{ number_format($order->total_price, 2) }} RSD</td>
                    <td>
                        <span class="badge bg-secondary order-status order-status-{{ $order->status }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-warning order-index-edit">Izmeni</a>

                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Da li ste sigurni da želite da obrišete ovu narudžbinu?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger order-index-delete">Obriši</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
