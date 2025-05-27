@extends('layouts.app')

@include('partials.header')

@section('content')
<div class="custom-detail-wrapper container my-5">
    <div class="row">
        <!-- Glavno jelo levo -->
        <div class="col-md-6">
            <div class="main-dish-box">
                <img src="{{ asset($jelo->image_path) }}" alt="{{ $jelo->name }}" class="main-dish-img">
                <h2 class="main-dish-title">{{ $jelo->name }}</h2>
                <p class="main-dish-desc">{{ $jelo->description }}</p>
                <p class="main-dish-price">Cena: {{ number_format($jelo->price, 2) }} RSD</p>
                <p class="main-dish-orders">Poručeno puta: {{ $jelo->total_orders }}</p>

                <!-- Dugme za poručivanje -->
                <a href="{{ route('order.add', ['id' => $jelo->id]) }}" class="btn btn-danger mt-3">Poruči</a>

            </div>
        </div>

        <!-- Pića i dezerti desno -->
        <div class="col-md-6">
            <div class="side-suggestions-box">
                <!-- Pića -->
                <h4 class="side-section-title">Preporučena pića</h4>
                <div class="row">
                    @foreach($pice as $p)
                        <div class="col-md-4 col-6 mb-3">
                            <a href="{{ route('dish.showWithSuggestions', ['id' => $p->id]) }}" class="text-decoration-none text-dark">
                                <div class="suggestion-card">
                                    <img src="{{ asset($p->image_path) }}" alt="{{ $p->name }}" class="suggestion-img">
                                    <p class="suggestion-name">{{ $p->name }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- Dezerti -->
                <h4 class="side-section-title mt-4">Preporučeni dezerti</h4>
                <div class="row">
                    @foreach($dezerti as $d)
                        <div class="col-md-4 col-6 mb-3">
                            <a href="{{ route('dish.showWithSuggestions', ['id' => $d->id]) }}" class="text-decoration-none text-dark">
                                <div class="suggestion-card">
                                    <img src="{{ asset($d->image_path) }}" alt="{{ $d->name }}" class="suggestion-img">
                                    <p class="suggestion-name">{{ $d->name }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@include('partials.footer')
@endsection
