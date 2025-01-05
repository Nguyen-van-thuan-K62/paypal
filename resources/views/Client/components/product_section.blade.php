<div class="card mb-5 ">
    <div class="card-body">
        <h5>Danh sách các sản phẩm</h5>
        <div class="row">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    @foreach($menus as $menu)
                    <div class="col-sm-6 col-md-4 col-lg-3 p-3" 
                         data-bs-toggle="popover"
                         data-bs-trigger="hover"
                         data-bs-html="true"
                         data-bs-content='
                            <h5>{{ $menu->name }}</h5>
                            <p>{{ $menu->description }}</p>'>
                        <div class="card zoom-card" style="width: 100%; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease;">
                            <img class="card-img-top img-thumbnail" src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" style="transition: transform 0.3s ease;">
                            <div class="card-body text-center">
                                <h6 class="card-title" style="font-weight: bold;">{{ $menu->description }}</h6>
                                <h5 class="card-price" style="color: #ff5722;">{{ $menu->price }} VND</h5>
                                <a href="/show/{{$menu->id}}" class="btn btn-success">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>