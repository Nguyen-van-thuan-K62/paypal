<!-- Navbar -->
<div class="container">
    <a class="navbar-brand" href="#">Unica</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Trang chủ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/product">Sản Phẩm</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Tin Tức</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Về Chúng Tôi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Liên Hệ</a>
            </li>
        </ul>
        <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-light" type="submit">Search</button>
        </form>
        <button type="button" class="btn btn-outline-light ms-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Bạn cần đăng nhập">Giỏ Hàng <span class="badge bg-danger"></span></button>
        <a href="/login" class="btn btn-outline-light ms-2">Đăng Nhập</a>
        <a class="btn btn-outline-light ms-2" href="#">Đăng Ký</a>
    </div>
</div>

@yield('navbar')