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

    <!-- Modal za izbor tipa porudžbine -->
    <div class="modal fade" id="orderTypeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">
        <h5 class="modal-title text-center mb-3">Izaberite tip porudžbine</h5>
        <div class="d-flex justify-content-around">
            <button type="button" class="btn btn-primary order-type-btn" data-type="delivery">Dostava</button>
            <button type="button" class="btn btn-secondary order-type-btn" data-type="takeaway">Lično preuzimanje</button>
        </div>
        </div>
    </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {

        // Svi linkovi koji otvaraju modal
        const orderLinks = document.querySelectorAll('.open-order-type-modal');

        orderLinks.forEach(link => {
            link.addEventListener('click', function(e){
                e.preventDefault();
                const targetUrl = link.getAttribute('href'); // gde ide link
                const modalEl = document.getElementById('orderTypeModal');
                const modal = new bootstrap.Modal(modalEl);
                modal.show();

                // Klik na dugme u modalu
                document.querySelectorAll('.order-type-btn').forEach(btn => {
                    btn.onclick = function(ev) {
                        ev.preventDefault();
                        const type = btn.dataset.type;

                        fetch(`/select-order-type/${type}`)
                            .then(() => {
                                modal.hide(); // zatvori modal
                                window.location.href = targetUrl; // ide na link
                            });
                    };
                });
            });
        });
    });
    </script>


</body>
</html>
