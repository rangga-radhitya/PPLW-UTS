@props(['item'])
@php($qty = (int)(data_get($item, 'quantity') ?? 1))
@php($price = (float)(data_get($item, 'price') ?? data_get($item, 'menu.price') ?? 0))
<div class="cart-item">
    <div>
        <div class="fw-semibold">{{ data_get($item, 'name') ?? data_get($item, 'menu.name') }}</div>
        <div class="text-muted small">Rp{{ number_format($price,0,',','.') }}</div>
    </div>
    <div class="d-flex align-items-center gap-2">
        <form method="POST" action="{{ url('/keranjang/' . (data_get($item, 'id') ?? data_get($item, 'menu_id'))) }}" class="d-flex align-items-center gap-1">
            @csrf @method('PATCH')
            <input type="hidden" name="quantity" value="{{ max(1, $qty - 1) }}">
            <button class="qty-btn" type="submit">−</button>
        </form>
        <span>{{ $qty }}</span>
        <form method="POST" action="{{ url('/keranjang/' . (data_get($item, 'id') ?? data_get($item, 'menu_id'))) }}" class="d-flex align-items-center gap-1">
            @csrf @method('PATCH')
            <input type="hidden" name="quantity" value="{{ $qty + 1 }}">
            <button class="qty-btn" type="submit">+</button>
        </form>
    </div>
</div>
