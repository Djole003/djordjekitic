@extends('admin.layouts.app')
@include('partials.header')

@section('content')
<div class="container mt-4">
    <h1 class="order-index-title mb-4">Narudžbine</h1>

    <div class="row">
        <!-- LEVA KOLONA: Na čekanju -->
        <div class="col-md-6">
            <h4>Na čekanju</h4>
            <div id="pending-orders">
                @foreach($pendingOrders as $order)
                    <div class="order-card mb-3 p-3 border rounded" data-id="{{ $order->id }}">
                        <p><strong>Korisnik:</strong> {{ $order->user->name ?? 'Nepoznato' }}</p>
                        <p><strong>Adresa:</strong> {{ $order->user->address ?? '-' }}</p>
                        <p><strong>Telefon:</strong> {{ $order->user->phone ?? '-' }}</p>
                        <p><strong>Ukupno:</strong> {{ number_format($order->total_price, 2) }} RSD</p>
                        <hr>
                        <p><strong>Proizvodi:</strong></p>
                        <ul>
                            @foreach($order->products as $product)
                                <li>
                                    {{ $product->name }} x{{ $product->pivot->quantity }}
                                    @if($product->pivot->size)
                                        (Veličina: {{ $product->pivot->size }})
                                    @endif
                                    @if($product->pivot->sos)
                                        , Sos: {{ $product->pivot->sos }}
                                    @endif
                                    @if($product->pivot->meat)
                                        , Meso: {{ $product->pivot->meat }}
                                    @endif
                                    @if($product->pivot->addons)
                                        , Dodaci: {{ implode(', ', $product->addons->pluck('name')->toArray()) }}
                                    @endif
                                    @if($product->pivot->note)
                                        , Poruka: {{ $product->pivot->note }}
                                    @endif
                                </li>
                            @endforeach
                        </ul>

                        <form action="{{ route('admin.orders.accept', $order->id) }}" method="POST" class="d-flex align-items-center mt-2">
                            @csrf
                            <label class="me-2 mb-0">Vreme pripreme (min):</label>
                            <input type="number" name="preparation_time" min="15" max="60" value="30" class="form-control me-2" style="width:80px;">
                            <button type="submit" class="btn btn-success">Prihvati</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- DESNA KOLONA: Prihvaćene i u pripremi -->
        <div class="col-md-6">
            <h4>U pripremi / Dostavlja se</h4>
            <div id="accepted-orders">
                @foreach($acceptedOrders as $order)
                    <div class="order-card mb-3 p-3 border rounded" data-id="{{ $order->id }}">
                        <p><strong>Korisnik:</strong> {{ $order->user->name ?? 'Nepoznato' }}</p>
                        <p><strong>Adresa:</strong> {{ $order->user->address ?? '-' }}</p>
                        <p><strong>Telefon:</strong> {{ $order->user->phone ?? '-' }}</p>
                        <p><strong>Ukupno:</strong> {{ number_format($order->total_price, 2) }} RSD</p>
                        <hr>
                        <p><strong>Proizvodi:</strong></p>
                        <ul>
                            @foreach($order->products as $product)
                                <li>
                                    {{ $product->name }} x{{ $product->pivot->quantity }}
                                    @if($product->pivot->size)
                                        (Veličina: {{ $product->pivot->size }})
                                    @endif
                                    @if($product->pivot->sos)
                                        , Sos: {{ $product->pivot->sos }}
                                    @endif
                                    @if($product->pivot->meat)
                                        , Meso: {{ $product->pivot->meat }}
                                    @endif
                                    @if($product->pivot->addons)
                                        , Dodaci: {{ implode(', ', $product->addons->pluck('name')->toArray()) }}
                                    @endif
                                    @if($product->pivot->note)
                                        , Poruka: {{ $product->pivot->note }}
                                    @endif
                                </li>
                            @endforeach
                        </ul>

                        @if($order->status === 'prihvaćena')
                            <form action="{{ route('admin.orders.delivered', $order->id) }}" method="POST" class="mt-2">
                                @csrf
                                <button type="submit" class="btn btn-primary">Spremno za dostavu</button>
                            </form>
                        @elseif($order->status === 'dostavlja se')
                            <span class="badge bg-info">Dostavlja se</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
