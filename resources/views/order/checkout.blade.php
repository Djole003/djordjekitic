@extends('layouts.app')
@include('partials.header')

@section('content')

<style>
.checkout-wrapper {
    width: 100%;
    display: flex;
    justify-content: center;
    padding: 30px 15px;
    background: #f5f5f5;
}

.checkout-container {
    width: 100%;
    max-width: 900px;
    background: white;
    padding: 35px 45px;
    border-radius: 20px;
    box-shadow: 0 10px 35px rgba(0,0,0,0.08);
    animation: fadeIn 0.5s ease;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}

.checkout-title {
    text-align: center;
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 30px;
    color: #2c3e50;
}

.checkout-form label {
    font-weight: 600;
    margin-bottom: 6px;
    display: block;
    color: #2c3e50;
}

.checkout-form input,
.checkout-form textarea {
    width: 100%;
    padding: 14px;
    border-radius: 10px;
    border: 1px solid #ccc;
    margin-bottom: 20px;
    transition: 0.2s;
    font-size: 1rem;
}

.checkout-form input:focus,
.checkout-form textarea:focus {
    outline: none;
    border-color: #27ae60;
    box-shadow: 0 0 8px rgba(39,174,96,0.3);
}

.summary-box {
    padding: 20px;
    border-radius: 15px;
    background: #f9fafb;
    margin-top: 25px;
    border: 1px solid #eee;
}

.summary-title {
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 15px;
    color: #2c3e50;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid #eee;
    font-size: 1rem;
}

.summary-total {
    margin-top: 15px;
    font-size: 1.4rem;
    font-weight: 800;
    color: #27ae60;
    text-align: right;
}

.btn-finish {
    width: 100%;
    padding: 16px;
    font-size: 1.3rem;
    font-weight: 700;
    border-radius: 40px;
    background: linear-gradient(90deg, #27ae60, #2ecc71);
    border: none;
    color: white;
    margin-top: 35px;
    transition: 0.2s;
}

.btn-finish:hover {
    background: linear-gradient(90deg, #219150, #27ae60);
    transform: scale(1.02);
    cursor: pointer;
}

@media(max-width: 768px) {
    .checkout-container {
        padding: 25px;
    }
}
</style>

<div class="checkout-wrapper">
    <div class="checkout-container">

        <h2 class="checkout-title">Detalji za dostavu</h2>

        <form action="{{ route('order.submit') }}" method="POST" class="checkout-form">
            @csrf

            <label>Ime i prezime</label>
            <input type="text" name="name" required
                   placeholder="Unesite ime i prezime"
                   value="{{ old('name', auth()->user()->name ?? '') }}">

            <label>Broj telefona</label>
            <input type="text" name="telefon" required
                   placeholder="065 123 4567"
                   value="{{ old('telefon', auth()->user()->telefon ?? '') }}">

            <label>Adresa dostave</label>
            <input type="text" name="adresa" required
                   placeholder="Ulica i broj, sprat, zvono..."
                   value="{{ old('adresa', auth()->user()->adresa ?? '') }}">

            <label>Napomena (opciono)</label>
            <textarea name="napomena" rows="3" placeholder="Npr. dodatno ljuto, ne zvoni...">{{ old('napomena') }}</textarea>

            <div class="summary-box">
                <div class="summary-title">Pregled porudžbine</div>

                @php $total = 0; @endphp

                @foreach(session('cart', []) as $item)
                    @php
                        $product = \App\Models\Product::find($item['product_id']);
                        $addons = $item['addons'] ?? [];
                        $cena = $product->price;
                        if($item['size'] === 'velika') $cena += 200;
                        if(!empty($addons)) $cena += count($addons) * 100;
                        $ukupno = $cena * $item['quantity'];
                        $total += $ukupno;
                    @endphp

                    <div class="summary-item">
                        <span>{{ $product->name }} × {{ $item['quantity'] }}</span>
                        <span>{{ $ukupno }} RSD</span>
                    </div>
                @endforeach

                <div class="summary-total">
                    Ukupno: {{ $total }} RSD
                </div>
            </div>

            <button type="submit" class="btn-finish">Potvrdi porudžbinu (Gotovina)</button>
        </form>

    </div>
</div>

@endsection
