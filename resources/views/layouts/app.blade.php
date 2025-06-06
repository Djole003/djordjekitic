<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />

    <!-- Dodaj Bootstrap JS CDN za test -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
</head>
<body>
    <div class="min-h-screen bg-gray-100">


        <main>
            @yield('content')
        </main>
    </div>


</body>
</html>
