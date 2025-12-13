@extends('layouts.app')
@include('partials.header')

@section('content')
<div class="container mt-5">
    <h2>Moje narudžbine</h2>

    @if($orders->isEmpty())
        <p>Još uvek nemate porudžbina.</p>
    @else
        @foreach($orders as $order)
            <div class="card mb-3 p-3">
                <p><strong>ID narudžbine:</strong> {{ $order->id }}</p>
                <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                <p><strong>Ukupno:</strong> {{ number_format($order->total_price, 2) }} RSD</p>
                <p><strong>Datum:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>

                <hr>
                <p><strong>Proizvodi:</strong></p>
                <ul>
                    @foreach($order->products as $product)
                        <li>
                            {{ $product->name }} 
                            @if($product->pivot->size) - Vel: {{ $product->pivot->size }} @endif
                            @if($product->pivot->sos) - Sos: {{ $product->pivot->sos }} @endif
                            @if($product->pivot->addons) - Dodaci: {{ implode(', ', json_decode($product->pivot->addons)) }} @endif
                            - Količina: {{ $product->pivot->quantity }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    @endif
</div>
@endsection
