<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />

    <!-- Dodaj Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('js/addToCart.js') }}"></script>

</head>
<body>
    <div class="min-h-screen bg-gray-100">

        {{-- Poruka o radnom vremenu --}}

        @if(!empty($openingMessage))
            <div class="alert alert-danger text-center m-0">
                {{ $openingMessage }}
            </div>
        @endif


        {{-- Poruka o grešci prilikom poručivanja van radnog vremena --}}
        @if(session('error'))
            <div class="alert alert-danger text-center m-0">
                {{ session('error') }}
            </div>
        @endif

        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
