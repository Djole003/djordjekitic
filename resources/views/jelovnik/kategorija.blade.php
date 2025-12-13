@extends('layouts.app')
@include('partials.header')

@section('content')

<div class="products-container mt-5" style="padding: 2rem; background: linear-gradient(135deg, #fff3e0, #ffe0b2); border-radius: 12px;">
    <h2 class="section-title mb-4 text-center" style="color:#d84315; font-weight:700;">{{ $category->name }}</h2>

    <div class="row g-3 justify-content-center">
        @foreach($products as $product)
        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
            <div class="card product-card h-100 text-center position-relative shadow-sm p-2" style="background-color:#fff8f0; border-radius:10px;">
                <a href="{{ route('dish.showWithSuggestions', $product->id) }}" class="text-decoration-none text-dark d-block h-100">
                    <img src="{{ asset($product->image_path) }}" class="card-img-top mb-2" alt="{{ $product->name }}" style="height:100px; object-fit:cover; border-radius:6px;">
                    <div class="card-body p-1">
                        <h6 class="card-title mb-1" style="font-size:0.85rem;">{{ $product->name }}</h6>
                        <p class="card-text mb-1 fw-bold" style="font-size:0.75rem;">{{ number_format($product->price, 2) }} RSD</p>
                    </div>
                </a>

                <?php
                $hideSize = $hideSos = $hideAddons = $hideMeat = 0;

                switch($category->slug){
                    case 'predjela-i-salate':
                        $hideSize = 1;
                        $hideSos = 1;
                        $hideAddons = 1; // sakrij dodatke
                        $hideMeat = 1;
                        break;

                    case 'supe':
                    case 'pirinac-i-nudle':
                        $hideSize = 1;
                        $hideSos = 1;
                        $hideAddons = 0; // prikaži dodatke
                        $hideMeat = 1;
                        break;

                    case 'dezerti':
                    case 'pice':
                        $hideSize = 1;
                        $hideSos = 1;
                        $hideAddons = 1; // sakrij dodatke
                        $hideMeat = 1;
                        break;


                    case 'morski-plodovi':
                    case 'jela-bez-mesa':
                        $hideSize = 1;
                        $hideMeat = 1;
                        break;

                    case 'jela-sa-mesom':
                        if(in_array($product->name, ['Kung pao piletina', 'Kraljevska Piletina'])){
                            $hideSos = 1;
                            $hideMeat = 1;
                        }
                        break;
                }
                ?>

                <button type="button"
                        class="btn btn-sm btn-success order-btn position-absolute bottom-0 start-50 translate-middle-x mb-2"
                        data-bs-toggle="modal"
                        data-bs-target="#addToCartModal"
                        data-id="{{ $product->id }}"
                        data-name="{{ $product->name }}"
                        data-price="{{ $product->price }}"
                        data-hide-size="{{ $hideSize }}"
                        data-hide-sos="{{ $hideSos }}"
                        data-hide-addons="{{ $hideAddons }}"
                        data-hide-meat="{{ $hideMeat }}"
                        data-category="{{ $category->slug }}"
                        style="font-size:0.75rem; padding:4px 8px;">
                    Poruči
                </button>

            </div>
        </div>
        @endforeach
    </div>
</div>

@include('partials.addToCartModal')

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addToCartModal = document.getElementById('addToCartModal');

    document.querySelectorAll('.order-btn').forEach(button => {
        button.addEventListener('click', function() {
            const productName = this.dataset.name;
            const hideSize = this.dataset.hideSize === "1";
            const hideSos = this.dataset.hideSos === "1";
            const hideAddons = this.dataset.hideAddons === "1";
            const hideMeat = this.dataset.hideMeat === "1";

            // Naslov modala
            addToCartModal.querySelector('.modal-title').textContent = "Dodaj u korpu: " + productName;

            // Sekcije
            const sizeSection = addToCartModal.querySelector('#sizeSection');
            const sosSection = addToCartModal.querySelector('#sosSection');
            const addonsSection = addToCartModal.querySelector('#addonsSection');
            const meatSection = addToCartModal.querySelector('#meatSection');

            if(sizeSection) sizeSection.style.display = hideSize ? 'none' : 'block';
            if(sosSection) sosSection.style.display = hideSos ? 'none' : 'block';
            if(addonsSection) addonsSection.style.display = hideAddons ? 'none' : 'block';
            if(meatSection) meatSection.style.display = hideMeat ? 'none' : 'block';

            // Required polja
            const sizeSelect = sizeSection ? sizeSection.querySelector('select') : null;
            const sosSelect = sosSection ? sosSection.querySelector('select') : null;
            const meatSelect = meatSection ? meatSection.querySelector('select') : null;

            if(sizeSelect) sizeSelect.required = !hideSize;
            if(sosSelect) sosSelect.required = !hideSos;
            if(meatSelect) meatSelect.required = !hideMeat;

            // Otvori modal
            const modal = new bootstrap.Modal(addToCartModal);
            modal.show();
        });
    });
});
</script>

@endsection
