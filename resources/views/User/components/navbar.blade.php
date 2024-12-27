<!-- Navbar -->
<div class="container">
    <a class="navbar-brand" href="#">Giày Authentic</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/user/userhome">Trang chủ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/user/product">Sản Phẩm</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/user/order">Đơn Hàng</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Về Chúng Tôi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Liên Hệ</a>
            </li>
        </ul>
        <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Tìm Kiếm..." aria-label="Search">
            <button class="btn btn-outline-light" type="submit">Tìm</button>
        </form>
        <a href="/user/cart">
            <button type="button" class="btn btn-outline-light ms-2"data-bs-placement="bottom">Giỏ Hàng<span class="badge bg-danger">{{ $cartCount }}</span></button>
        </a>
        <a href="/user" class="text-decoration-none text-white ms-5 ">
            {{ Auth::user()->name }}
        </a>
        <form action="/logout" method="POST">
            @csrf
            <button class="ms-1 text-white bg-dark border-0 ">Đăng xuất</button>
        </form>
    </div>
</div>

@yield('navbar')