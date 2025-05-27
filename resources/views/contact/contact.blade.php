@extends('layouts.app')
@include('partials.header')

@section('content')
<div class="container">

    <h1>Kontakt</h1>

    @if(session('success'))
        <div style="color: green; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="margin-bottom: 30px;">
        <h3>Kontakt podaci</h3>
        <p><strong>Telefon:</strong> {{ $contactData['phone'] }}</p>
        <p><strong>Email:</strong> {{ $contactData['email'] }}</p>
        <p><strong>Adresa:</strong> {{ $contactData['address'] }}</p>
    </div>

    <div style="margin-bottom: 30px;">
        <h3>Mapa - Mister Wang, Borska 45i</h3>
        <div id="map" style="width: 100%; height: 450px;"></div>
    </div>

    <div style="margin-bottom: 30px;">
        <h3>Ostavi recenziju</h3>

        @auth
            <form action="{{ route('contact.review.submit') }}" method="POST">
                @csrf

                {{-- Ocena --}}
                <div>
                    <label for="rating">Ocena (1-5):</label><br>
                    <select id="rating" name="rating" required>
                        <option value="">-- Odaberi ocenu --</option>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    @error('rating') <div style="color: red;">{{ $message }}</div> @enderror
                </div>

                {{-- Komentar --}}
                <div>
                    <label for="message">Poruka:</label><br>
                    <textarea id="message" name="message" rows="4" required>{{ old('message') }}</textarea>
                    @error('message') <div style="color: red;">{{ $message }}</div> @enderror
                </div>

                <button type="submit" style="margin-top: 10px;">Pošalji</button>
            </form>
        @else
            <p>Da biste ostavili recenziju, morate biti <a href="{{ route('login') }}">prijavljeni</a>.</p>
        @endauth
    </div>

    <div>
        <h3>Recenzije korisnika</h3>

        @if($reviews->isEmpty())
            <p>Još uvek nema recenzija.</p>
        @else
            @foreach($reviews as $review)
                <div style="border-bottom: 1px solid #ccc; padding: 10px 0;">
                    <strong>{{ $review->user->name ?? 'Nepoznat korisnik' }}</strong> 
                    <span style="color: #999;">({{ $review->created_at->format('d.m.Y') }})</span><br>
                    <em>Ocena: {{ $review->rating }}/5</em><br>
                    <p>{{ $review->comment }}</p>
                </div>
            @endforeach
        @endif
    </div>

</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // Prikaz mape sa centrom na tacnoj lokaciji
    var map = L.map('map').setView([44.75719879366028, 20.459915494039834], 17);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    L.marker([44.75719879366028, 20.459915494039834]).addTo(map)
        .bindPopup('Mister Wang<br>Borska 45i, Beograd')
        .openPopup();
</script>
@endsection
