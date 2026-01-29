@extends('layouts.app')
@include('partials.header')

@section('content')
<div class="container contact-container">

    {{-- SEO H1 --}}
    <h1 class="contact-title">
        Kontakt – Mister Wang kineski restoran Beograd
    </h1>

    {{-- SEO opis --}}
    <p style="max-width:720px; margin:0 auto 30px; color:#555; font-size:0.95rem; text-align:center;">
        Kontaktirajte kineski restoran Mister Wang u Beogradu.
        Poručite hranu, proverite radno vreme ili ostavite recenziju.
    </p>

    {{-- Kontakt kartice --}}
    <div class="contact-cards">

        <div class="contact-card">
            <i class="fas fa-phone-alt contact-icon"></i>
            <div>
                <h2 style="font-size:1.1rem;">Telefon</h2>
                <p>+381 64 52 14 800</p>
                <p>+381 64 52 14 802</p>
            </div>
        </div>

        <div class="contact-card">
            <i class="fas fa-envelope contact-icon"></i>
            <div>
                <h2 style="font-size:1.1rem;">Email</h2>
                <p>djordjekitic2003@gmail.com</p>
            </div>
        </div>

        <div class="contact-card">
            <i class="fas fa-map-marker-alt contact-icon"></i>
            <div>
                <h2 style="font-size:1.1rem;">Adresa</h2>
                <p>Borska 45i, Beograd</p>
            </div>
        </div>

    </div>

    {{-- Radno vreme --}}
    <div class="working-hours mb-4">
        <h2 style="font-size:1.2rem;">Radno vreme restorana</h2>
        <p>Radnim danima: 9–22h</p>
        <p>Nedelja: 11–20h</p>
        <p>Subota: Ne radimo</p>
    </div>

    {{-- Mapa --}}
    <div class="map-container mb-4">
        <h2 style="font-size:1.2rem;">
            Lokacija restorana Mister Wang – Beograd
        </h2>
        <p style="font-size:0.9rem; color:#666;">
            Dostava hrane dostupna po zonama u Beogradu. Pogledajte mapu ispod.
        </p>
        <div id="map"></div>
    </div>

    {{-- Recenzije --}}
    <div class="reviews-container">
        <h2 style="font-size:1.2rem;">Ostavite recenziju</h2>

        @auth
            <form action="{{ route('contact.review.submit') }}" method="POST" class="review-form">
                @csrf

                <div class="mb-2">
                    <label for="rating">Ocena (1–5):</label><br>
                    <select id="rating" name="rating" required>
                        <option value="">-- Odaberi ocenu --</option>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    @error('rating') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="mb-2">
                    <label for="message">Poruka:</label><br>
                    <textarea id="message" name="message" rows="4" required>{{ old('message') }}</textarea>
                    @error('message') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-primary">Pošalji</button>
            </form>
        @else
            <p>
                Da biste ostavili recenziju, morate biti
                <a href="{{ route('login') }}">prijavljeni</a>.
            </p>
        @endauth
    </div>

    {{-- Prikaz recenzija --}}
    <div class="user-reviews mt-4">
        <h2 style="font-size:1.2rem;">Iskustva korisnika</h2>

        @if($reviews->isEmpty())
            <p>Još uvek nema recenzija.</p>
        @else
            @foreach($reviews as $review)
                <div class="review-card">
                    <strong>{{ $review->user->name ?? 'Nepoznat korisnik' }}</strong>
                    <span class="review-date">
                        ({{ $review->created_at->format('d.m.Y') }})
                    </span><br>
                    <em>Ocena: {{ $review->rating }}/5</em>
                    <p>{{ $review->comment }}</p>
                </div>
            @endforeach
        @endif
    </div>

</div>


{{-- Leaflet mapa --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    var center = [44.75719879366028, 20.459915494039834];

    var map = L.map('map').setView(center, 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // 🟢 ZELENA – 0–2 km
    L.circle(center, {
        color: 'green',
        fillColor: 'green',
        fillOpacity: 0.25,
        radius: 2000
    }).addTo(map).bindPopup("🟢 Zelena zona<br>100 RSD");

    // 🟡 ŽUTA – 2–4 km
    L.circle(center, {
        color: 'yellow',
        fillColor: 'yellow',
        fillOpacity: 0.25,
        radius: 4000
    }).addTo(map).bindPopup("🟡 Žuta zona<br>150 RSD");

    // 🟠 NARANDŽASTA – 4–6 km
    L.circle(center, {
        color: 'orange',
        fillColor: 'orange',
        fillOpacity: 0.25,
        radius: 6000
    }).addTo(map).bindPopup("🟠 Narandžasta zona<br>200 RSD");

    // 🔴 CRVENA – 6–8.5 km (Resnik, Sremčica)
    L.circle(center, {
        color: 'red',
        fillColor: 'red',
        fillOpacity: 0.25,
        radius: 8500
    }).addTo(map).bindPopup("🔴 Crvena zona<br>250 RSD");

    // 📍 Marker restorana
    L.marker(center).addTo(map)
        .bindPopup("<b>Mister Wang</b><br>Borska 45i, Beograd")
        .openPopup();
</script>






@include('partials.footer')

@endsection


