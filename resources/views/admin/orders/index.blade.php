@extends('admin.layouts.app')


@section('content')

<style>
/* ===============================
   ADMIN ORDERS – CUSTOM CSS
   =============================== */

.orders-wrapper {
    padding: 20px;
}

.orders-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

.order-column {
    background: #f9fafb;
    border-radius: 12px;
    padding: 15px;
    min-height: 80vh;
}

.order-column h3 {
    text-align: center;
    margin-bottom: 15px;
    font-size: 20px;
    font-weight: 600;
}

.order-card {
    background: #ffffff;
    border-radius: 10px;
    padding: 12px;
    margin-bottom: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    border-left: 5px solid #ddd;
}

.order-card.waiting { border-color: #f59e0b; }
.order-card.preparing { border-color: #3b82f6; }
.order-card.delivering { border-color: #10b981; }

.order-header {
    display: flex;
    justify-content: space-between;
    font-weight: 600;
    margin-bottom: 8px;
}

.order-products {
    font-size: 14px;
    margin-bottom: 10px;
}

.order-products div {
    display: flex;
    justify-content: space-between;
}

.order-actions {
    margin-top: 10px;
}

.order-actions input {
    width: 100%;
    padding: 6px;
    margin-bottom: 6px;
    border-radius: 6px;
    border: 1px solid #ccc;
}

.order-actions button {
    width: 100%;
    padding: 8px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-weight: 600;
}

.btn-accept {
    background: #3b82f6;
    color: #fff;
}

.btn-ready {
    background: #10b981;
    color: #fff;
}

@media(max-width: 900px) {
    .orders-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="orders-wrapper">
    <div class="orders-grid">

        {{-- NA CEKANJU --}}
        <div class="order-column">
            <h3>🕒 Na čekanju</h3>

            @foreach($waitingOrders as $order)
                <div class="order-card waiting">
                    <div class="order-header">
                        <span>#{{ $order->id }}</span>
                        <span>{{ $order->created_at->format('H:i') }}</span>
                    </div>

                    <div class="order-products">
                        @foreach($order->orderProducts as $item)
                            <div>
                                <span>{{ $item->product->name }}</span>
                                <span>x{{ $item->quantity }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="order-actions">
                        <input type="number" min="1" max="180" placeholder="Vreme (min)"
                               id="prep-{{ $order->id }}">
                        <button class="btn-accept"
                                onclick="acceptOrder({{ $order->id }})">
                            Prihvati
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- U PRIPREMI --}}
        <div class="order-column">
            <h3>🍳 U pripremi</h3>

            @foreach($preparingOrders as $order)
                <div class="order-card preparing">
                    <div class="order-header">
                        <span>#{{ $order->id }}</span>
                        <span>do {{ optional($order->ready_at)->format('H:i') }}</span>
                    </div>

                    <div class="order-products">
                        @foreach($order->orderProducts as $item)
                            <div>
                                <span>{{ $item->product->name }}</span>
                                <span>x{{ $item->quantity }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="order-actions">
                        <button class="btn-ready"
                                onclick="readyOrder({{ $order->id }})">
                            Spremno
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- DOSTAVLJA SE --}}
        <div class="order-column">
            <h3>🚚 Dostavlja se</h3>

            @foreach($deliveringOrders as $order)
                <div class="order-card delivering">
                    <div class="order-header">
                        <span>#{{ $order->id }}</span>
                        <span>u toku</span>
                    </div>

                    <div class="order-products">
                        @foreach($order->orderProducts as $item)
                            <div>
                                <span>{{ $item->product->name }}</span>
                                <span>x{{ $item->quantity }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>

<script>
function acceptOrder(id) {
    const time = document.getElementById('prep-' + id).value;

    if (!time) {
        alert('Unesi vreme pripreme');
        return;
    }

    fetch(`/admin/orders/${id}/accept`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ preparation_time: time })
    }).then(() => location.reload());
}

function readyOrder(id) {
    fetch(`/admin/orders/${id}/ready`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    }).then(() => location.reload());
}
</script>

@endsection
