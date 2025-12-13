@extends('layouts.app')
@include('partials.header')

<!-- HERO SECTION -->
<section class="hero position-relative">
    <a href="{{ route('jelovnik') }}" class="text-decoration-none">
        <div class="hero-image" style="background-image: url('{{ asset('assets/hero.jpg') }}'); height: 70vh; background-size: cover; background-position: center;">
            <div class="hero-overlay d-flex flex-column justify-content-center align-items-center text-white text-center h-100" style="background: rgba(0,0,0,0.4);">
                <h1 class="display-4 fw-bold">Poruči odmah!</h1>
                <p class="fs-5 mb-3">Autentični kineski ukusi, brzo i kvalitetno!</p>
                <a href="{{ route('jelovnik') }}" class="btn btn-danger btn-lg">Pogledaj jelovnik</a>
            </div>
        </div>
    </a>
</section>

<section class="hero-slider-section">
    <div class="hero-slider-container">
        <!-- Slide 1 -->
        <div class="dish-slide show">
            <div class="dish-content">
                <p class="dish-category">Predjelo</p>
                <h2 class="dish-title">Rolnice sa povrćem</h2>
                <p class="dish-description">Hrskave rolnice punjene svežim povrćem, savršen početak obroka.</p>
                <a href="#" class="btn btn-details">Detalji proizvoda</a>
            </div>
            <div class="dish-image">
                <img src="{{ asset('assets/rolnice_povrce.jpg') }}" alt="Rolnice sa povrćem">
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="dish-slide">
            <div class="dish-content">
                <p class="dish-category">Glavno jelo</p>
                <h2 class="dish-title">Kraljevska Piletina</h2>
                <p class="dish-description">Sočna piletina u aromatičnom sosu sa povrćem i začinima.</p>
                <a href="#" class="btn btn-details">Detalji proizvoda</a>
            </div>
            <div class="dish-image">
                <img src="{{ asset('assets/kralj.jpg') }}" alt="Kraljevska Piletina">
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="dish-slide">
            <div class="dish-content">
                <p class="dish-category">Glavno jelo</p>
                <h2 class="dish-title">Kung Pao Piletina <span style="color:#FF4D4D;">(Specijalitet kuće)</span></h2>
                <p class="dish-description">Autentična piletina sa kikirikijem i začinima, sočna i pikantna.</p>
                <a href="#" class="btn btn-details">Detalji proizvoda</a>
            </div>
            <div class="dish-image">
                <img src="{{ asset('assets/kung_pao.jpg') }}" alt="Kung Pao Piletina">
            </div>
        </div>

        <!-- Slide 4 -->
        <div class="dish-slide">
            <div class="dish-content">
                <p class="dish-category">Vegetarijansko</p>
                <h2 class="dish-title">Mešano povrće</h2>
                <p class="dish-description">Sveže i sezonsko povrće prženo sa aromatičnim kineskim začinima.</p>
                <a href="#" class="btn btn-details">Detalji proizvoda</a>
            </div>
            <div class="dish-image">
                <img src="{{ asset('assets/mesano_povrce.jpg') }}" alt="Mešano povrće">
            </div>
        </div>

        <!-- Slide 5 -->
        <div class="dish-slide">
            <div class="dish-content">
                <p class="dish-category">Dezert</p>
                <h2 class="dish-title">Pohovana banana</h2>
                <p class="dish-description">Sladak i hrskav dezert, idealan završetak obroka.</p>
                <a href="#" class="btn btn-details">Detalji proizvoda</a>
            </div>
            <div class="dish-image">
                <img src="{{ asset('assets/poh_banana.jpg') }}" alt="Pohovana banana">
            </div>
        </div>

        <!-- Slider kontrole -->
        <button class="slider-btn prev">&#10094;</button>
        <button class="slider-btn next">&#10095;</button>
    </div>
</section>






<section class="about-us py-5 bg-light">
    <div class="container text-center">
        <h2 class="fw-bold mb-4">Zašto izabrati Mister Wang?</h2>
        <p class="mb-5">
            U Mister Wangu verujemo da hrana nije samo obrok – to je iskustvo! 
            Naši recepti kombinuju autentične kineske ukuse sa svežim namirnicama, 
            brzo i precizno pripremljene, kako bi svaki zalogaj bio pravi užitak.
        </p>
        <div class="row justify-content-center g-4 features-row">
            <div class="col-6 col-sm-4 col-md-2">
                <div class="feature-item">
                    <img src="{{ asset('assets/sveze-namirnice.jpg') }}" alt="Sveže namirnice">
                    <h6>Sveže namirnice</h6>
                    <p>Biramo samo najkvalitetnije sastojke.</p>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-md-2">
                <div class="feature-item">
                    <img src="{{ asset('assets/brza-dostava.jpg') }}" alt="Brza dostava">
                    <h6>Brza dostava</h6>
                    <p>Vaša porudžbina stiže tačno i brzo.</p>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-md-2">
                <div class="feature-item">
                    <img src="{{ asset('assets/autenticni-recepti.jpg') }}" alt="Autentični recepti">
                    <h6>Autentični recepti</h6>
                    <p>Pravimo hranu po originalnim kineskim receptima.</p>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-md-2">
                <div class="feature-item">
                    <img src="{{ asset('assets/sigurna-priprema.jpg') }}" alt="Sigurna priprema">
                    <h6>Sigurna priprema</h6>
                    <p>Sve se priprema u higijenskim uslovima.</p>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-md-2">
                <div class="feature-item">
                    <img src="{{ asset('assets/odlicna-podrska.png') }}" alt="Odlična podrška">
                    <h6>Odlična podrška</h6>
                    <p>Naš tim je uvek spreman da odgovori na vaše zahteve.</p>
                </div>
            </div>
        </div>
    </div>
</section>





<!-- CATEGORIES SECTION -->
<section class="categories py-5 bg-light">
    <div class="container text-center">
        <h2 class="fw-bold mb-4">Istraži naše kategorije</h2>
        <div class="row justify-content-center g-3">
            @php
                $dummyCategories = [
                    ['name'=>'Predjela','slug'=>'predjela','image'=>'assets/cat1.jpg'],
                    ['name'=>'Supe','slug'=>'supe','image'=>'assets/cat2.jpg'],
                    ['name'=>'Pirinac & Nudle','slug'=>'pirinac-i-nudle','image'=>'assets/cat3.jpg'],
                    ['name'=>'Morski plodovi','slug'=>'morski-plodovi','image'=>'assets/cat4.jpg'],
                    ['name'=>'Dezerti','slug'=>'dezerti','image'=>'assets/cat5.jpg'],
                ];
            @endphp
            @foreach($dummyCategories as $category)
            <div class="col-6 col-sm-4 col-md-2">
                <a href="{{ route('jelovnik.kategorija', $category['slug']) }}" class="text-decoration-none text-dark">
                    <div class="card h-100 p-2 shadow-sm hover-scale" style="transition: transform 0.2s;">
                        <img src="{{ asset($category['image']) }}" class="card-img-top mb-2" style="height:80px; object-fit:cover; border-radius:6px;">
                        <p class="fw-bold mb-0">{{ $category['name'] }}</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ABOUT / CTA -->
<section class="cta py-5">
    <div class="container text-center">
        <h2 class="fw-bold mb-3">Spreman za porudžbinu?</h2>
        <p class="mb-4">Izaberi omiljena jela i naruči brzo i jednostavno!</p>
        <a href="{{ route('jelovnik') }}" class="btn btn-danger btn-lg">Poruči sada</a>
    </div>
</section>

@include('partials.footer')

<style>
.hero-image { width: 100%; }
.hover-scale:hover { transform: scale(1.05); transition: transform 0.2s; }
@media (max-width:768px) {
    .hero-image { height: 50vh !important; }
}
</style>


<script>
document.addEventListener("DOMContentLoaded", function() {
    const items = document.querySelectorAll('.feature-item');

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if(entry.isIntersecting){
                entry.target.classList.add('show');
            }
        });
    }, { threshold: 0.2 }); // 20% vidljivo

    items.forEach(item => observer.observe(item));
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let currentSlide = 0;
    const slides = document.querySelectorAll('.dish-slide');
    const totalSlides = slides.length;

    const prevBtn = document.querySelector('.slider-btn.prev');
    const nextBtn = document.querySelector('.slider-btn.next');

    function showSlide(index){
        slides.forEach((slide, i) => {
            slide.classList.remove('show');
            slide.style.zIndex = 1;
        });
        slides[index].classList.add('show');
        slides[index].style.zIndex = 5;
    }

    showSlide(currentSlide);

    let slideInterval = setInterval(() => {
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
    }, 5000);

    nextBtn.addEventListener('click', () => {
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
        resetInterval();
    });

    prevBtn.addEventListener('click', () => {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        showSlide(currentSlide);
        resetInterval();
    });

    function resetInterval(){
        clearInterval(slideInterval);
        slideInterval = setInterval(() => {
            currentSlide = (currentSlide + 1) % totalSlides;
            showSlide(currentSlide);
        }, 5000);
    }
});


</script>
