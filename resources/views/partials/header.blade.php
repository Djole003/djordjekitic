<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Mister Wang</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo.png') }}" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />

</head>
<body>
    <!-- Responsive navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
        <a class="navbar-brand" href="/">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo" style="height: 40px; border-radius:7px;">
        </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span
                    class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="/jelovnik">Jelovnik</a></li>
                    <li class="nav-item"><a class="nav-link" href="/kontakt">Kontakt</a></li>

                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Prijava</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registracija</a></li>
                    @endguest

                    @auth

                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'editor')
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Urednicki deo</a></li>
                    @endif


                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link" style="color: white; text-decoration: none;">
                                    Odjava ({{ auth()->user()->name }})
                                </button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Flash poruke -->
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <!-- Korpa -->
    <a href="{{ route('order.cart') }}" class="cart-icon-wrapper" title="Korpa">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-cart" viewBox="0 0 16 16">
            <path d="M0 1.5A.5.5 0 0 1 .5 1h1a.5.5 0 0 1 .485.379L2.89 6H14.5a.5.5 0 0 1 .49.598l-1.5 7A.5.5 0 0 1 13 14H4a.5.5 0 0 1-.491-.408L1.01 2H.5a.5.5 0 0 1-.5-.5zm3.14 5l1.25 5h7.22l1.25-5H3.14zM5 16a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm7-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
        </svg>

        @php
            $cart = session('order', []);
            $count = 0;
            foreach ($cart as $item) {
                $count += $item['kolicina'];
            }
        @endphp
        @if($count > 0)
            <span class="badge">{{ $count }}</span>
        @endif
    </a>
