@extends('layouts.app')

@include('partials.header')

@section('content')

<div class="container">

    {{-- Kategorije --}}
    <div class="categories-container">
        <h2 class="section-title">Jelovnik Mister Wang</h2>
        <div class="categories-grid">
            @foreach($categories as $category)
                <a href="{{ route('jelovnik.kategorija', ['slug' => $category->slug]) }}" class="category-card">
                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}">
                    <div class="category-name">{{ $category->name }}</div>
                </a>
            @endforeach
        </div>
    </div>

</div>


<script>
    // Slider
    const slider = document.querySelector('.top-dishes-slider');
    const nextBtn = document.querySelector('.slider-btn.next');
    const prevBtn = document.querySelector('.slider-btn.prev');

    let offset = 0;
    const cardWidth = 320;

    nextBtn.addEventListener('click', () => {
        if (Math.abs(offset) < slider.scrollWidth - slider.clientWidth) {
            offset -= cardWidth;
            slider.style.transform = `translateX(${offset}px)`;
        }
    });

    prevBtn.addEventListener('click', () => {
        if (offset < 0) {
            offset += cardWidth;
            slider.style.transform = `translateX(${offset}px)`;
        }
    });

    
</script>
@endsection
