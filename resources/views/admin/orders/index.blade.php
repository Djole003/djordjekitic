@extends('admin.layouts.admin')

@section('title', 'Narudžbine')
@section('header-title', 'Narudžbine')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- ================= LIVE NARUDŽBINE ================= --}}
<div class="row g-4 mb-5">

    {{-- NA ČEKANJU --}}
    <div class="col-12 col-md-6 col-xl-6" id="waiting-column">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="text-warning mb-0">🟡 Na čekanju</h5>
            <span class="badge bg-warning text-dark fs-6 waiting-count">
                {{ $waitingOrders->count() }}
            </span>
        </div>

        @forelse($waitingOrders as $order)
            @include('admin.orders.order-card', ['order' => $order])
        @empty
            <div class="alert alert-light text-center text-muted">
                Nema novih narudžbina
            </div>
        @endforelse
    </div>

    {{-- U PRIPREMI --}}
    <div class="col-12 col-md-6 col-xl-6" id="preparing-column">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="text-primary mb-0">🔵 U pripremi</h5>
            <span class="badge bg-primary fs-6">
                {{ $preparingOrders->count() }}
            </span>
        </div>

        @forelse($preparingOrders as $order)
            @include('admin.orders.order-card', ['order' => $order])
        @empty
            <div class="alert alert-light text-center text-muted">
                Nema porudžbina u pripremi
            </div>
        @endforelse
    </div>

</div>

{{-- ================= MODAL ================= --}}
<div class="modal fade" id="acceptOrderModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Vreme pripreme</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <p class="mb-3">Izaberi vreme pripreme (minuti)</p>

                <div class="d-flex flex-wrap justify-content-center gap-2">
                    @foreach([5,10,15,20,25,30,40,50,60] as $min)
                        <button
                            class="btn btn-outline-primary prep-time-btn"
                            data-minutes="{{ $min }}">
                            {{ $min }} min
                        </button>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>
@endsection


@section('scripts')
<script>
let selectedOrderId = null;
let countdownIntervals = [];
const csrf = document.querySelector('meta[name="csrf-token"]').content;

/* ---------- CLICK HANDLER ---------- */
document.addEventListener('click', function (e) {

    if (e.target.classList.contains('open-accept-modal')) {
        selectedOrderId = e.target.dataset.id;
        new bootstrap.Modal(document.getElementById('acceptOrderModal')).show();
    }

    if (e.target.classList.contains('prep-time-btn')) {
        const minutes = parseInt(e.target.dataset.minutes);

        fetch(`/admin/orders/${selectedOrderId}/accept`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrf,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ minutes })
        })
        .then(() => refreshOrders());
    }

    if (e.target.classList.contains('mark-ready-btn')) {
        const orderId = e.target.dataset.id;

        fetch(`/admin/orders/${orderId}/ready`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json'
            }
        })
        .then(() => refreshOrders());
    }
});

/* ---------- REFRESH ---------- */
function refreshOrders() {
    fetch(location.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.text())
        .then(html => {
            const doc = new DOMParser().parseFromString(html, 'text/html');

            document.getElementById('waiting-column').innerHTML =
                doc.getElementById('waiting-column').innerHTML;

            document.getElementById('preparing-column').innerHTML =
                doc.getElementById('preparing-column').innerHTML;

            startCountdowns();
        });
}

/* ---------- COUNTDOWN ---------- */
function startCountdowns() {

    countdownIntervals.forEach(i => clearInterval(i));
    countdownIntervals = [];

    document.querySelectorAll('.countdown').forEach(el => {

        const readyAt = new Date(el.dataset.readyAt);
        const lateBadge = el.closest('.alert')?.querySelector('.late-badge');

        function tick() {
            const diff = Math.floor((readyAt - new Date()) / 1000);

            if (diff <= 0) {
                el.textContent = '00:00';
                el.classList.add('text-danger');
                if (lateBadge) lateBadge.classList.remove('d-none');
                return;
            }

            const m = Math.floor(diff / 60);
            const s = diff % 60;
            el.textContent = `${m}:${s.toString().padStart(2, '0')}`;

            if (diff <= 120) el.classList.add('text-danger');
        }

        tick();
        countdownIntervals.push(setInterval(tick, 1000));
    });
}

document.addEventListener('DOMContentLoaded', () => {
    startCountdowns();
    setInterval(refreshOrders, 5000);
});
</script>
@endsection
