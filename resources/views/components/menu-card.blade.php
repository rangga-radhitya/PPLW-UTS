@props(['menu'])
<div class="card menu-card h-100">
    @php($image = data_get($menu, 'image'))
    @if($image)
        <img src="{{ asset('images/menu/' . $image) }}" class="menu-image" alt="{{ data_get($menu, 'name', 'Menu') }}">
    @else
        <div class="menu-image placeholder-image">Food Photo</div>
    @endif
    <div class="card-body d-flex flex-column">
        <span class="small text-muted">{{ data_get($menu, 'category.name') ?? data_get($menu, 'category', '') }}</span>
        <h3 class="menu-name">{{ data_get($menu, 'name', 'Menu') }}</h3>
        <p class="menu-price">Rp{{ number_format((float)data_get($menu, 'price', 0), 0, ',', '.') }}</p>
        @if((bool)data_get($menu, 'is_available', true))
            <a href="{{ url('/menu/' . data_get($menu, 'id')) }}" class="btn btn-bowlmate mt-auto">Lihat Detail</a>
        @else
            <button class="btn btn-secondary mt-auto" disabled>Habis</button>
        @endif
    </div>
</div>
