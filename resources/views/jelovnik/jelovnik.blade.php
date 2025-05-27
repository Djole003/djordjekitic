@include('partials.header')
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="fw-bold text-center mb-4">Naš jelovnik</h2>
    
    {{-- Input za pretragu --}}
    <div class="text-center mb-4">
        <input type="text" id="pretraga-jela" class="form-control w-50 mx-auto" placeholder="Pretraži jela...">
    </div>

    @foreach($productsByCategory as $category => $products)
        <h3 class="mt-4">{{ $category }}</h3>
        
        <div class="row justify-content-center">
            @foreach($products as $jelo)
                {{-- Dodata klasa jela-kartica za filtriranje --}}
                <div class="col-md-4 jela-kartica">
                    <div class="card mb-4">
                        <img src="{{ asset($jelo->image_path) }}" class="card-img-top" alt="{{ $jelo->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $jelo->name }}</h5>
                            <p class="card-text opis-jela">{{ Str::limit($jelo->description, 100) }}</p>
                            <p class="card-text"><strong>Cena:</strong> {{ $jelo->price }} RSD</p>
                            <a href="{{ route('dish.showWithSuggestions', $jelo->id) }}" class="btn btn-primary">Detalji</a>
                            <a href="{{ route('order.add', $jelo->id) }}" class="btn btn-success">Poruči</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>

@include('partials.footer')

{{-- JavaScript za pretragu po nazivu i opisu --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('pretraga-jela');
        input.addEventListener('keyup', function () {
            const filter = input.value.toLowerCase();
            const jela = document.querySelectorAll('.jela-kartica');

            jela.forEach(jelo => {
                const naziv = jelo.querySelector('.card-title').textContent.toLowerCase();
                const opis = jelo.querySelector('.opis-jela').textContent.toLowerCase();

                if (naziv.includes(filter) || opis.includes(filter)) {
                    jelo.style.display = 'block';
                } else {
                    jelo.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection
