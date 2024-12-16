<div id="demo" class="carousel slide mt-5" data-bs-ride="carousel">
    <div class="carousel-indicators">
        @foreach ($carousel as $index => $menu)
            <button type="button" data-bs-target="#demo" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></button>
        @endforeach
    </div>
    <div class="carousel-inner active">
        @foreach ($carousel  as $index => $menu)
            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                <img src="{{ asset('storage/' . $menu->image) }}" alt="Slide {{ $index + 1 }}" class="d-block w-100 h-100 img-fluid"> <!-- Thêm class img-fluid -->
                <div class="carousel-caption d-none d-md-block">
                </div>
            </div>
        @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
    });
</script>

@yield('carousel')