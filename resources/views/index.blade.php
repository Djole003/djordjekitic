@include('partials.header')

<!-- Hero Image with Overlay + Link -->
<a href="{{ route('jelovnik') }}" style="text-decoration: none;">
    <div class="hero-image" style="background-image: url('{{ asset('assets/hero.jpg') }}'); cursor: pointer;">
        <div class="hero-overlay">
            <div class="hero-text text-center text-white">
                <h1 class="fw-bold">Poruči odmah!</h1>
                <p class="fs-5">Autentični kineski ukusi, brzo i kvalitetno!</p>
            </div>
        </div>
    </div>
</a>

<h2 class="fw-bold mt-5">Najpopularnija jela</h2>
<p class="fs-6">Pogledajte jela koja su najviše naručivana.</p>

<!-- Grid for Popular Dishes -->
<div class="row justify-content-center">
    @foreach($popularDishes as $dish)
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="{{ asset($dish->image_path) }}" class="card-img-top" alt="{{ $dish->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $dish->name }}</h5>
                    <p class="card-text">Broj porudžbina: {{ $dish->total_orders }}</p>
                    <a href="{{ route('dish.showWithSuggestions', $dish->id) }}" class="btn btn-primary">Detalji</a>
                </div>
            </div>
        </div>
    @endforeach
</div>

@include('partials.footer')
