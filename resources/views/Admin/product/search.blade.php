@extends('admin.components.main')
@section('content')
<div class="content-wrapper" style="min-height: 2012.94px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <h2 class="text-center display-4">Tìm Kiếm</h2>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <form action="/admin/product/search" method="post" id="search-form">
                    {{ csrf_field() }}
                        <div class="input-group input-group-lg">
                            <input type="text" name="name" id="header-search" class="form-control form-control-lg" placeholder="Nhập từ khóa tìm kiếm ở đây!">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-lg btn-default">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Nơi kết quả tìm kiếm sẽ được hiển thị -->
                    <div id="search-results" class="mt-3"></div>
                </div>
            </div>
        </div>
    </section>    
</div>
@endsection

<!-- JavaScript để xử lý tìm kiếm và hiển thị kết quả -->
{{-- <script type="text/javascript">
    $(document).ready(function() {
        // Khi người dùng nhấn nút "Tìm kiếm" hoặc submit form
        $('#search-form').on('submit', function(e) {
            e.preventDefault(); // Ngăn việc submit form và tải lại trang

            // Lấy giá trị từ ô tìm kiếm
            var searchQuery = $('#header-search').val(); 

            // Nếu ô tìm kiếm trống, không làm gì cả
            if (searchQuery === '') {
                $('#search-results').html('<p>Vui lòng nhập từ khóa tìm kiếm!</p>'); // Hiển thị thông báo yêu cầu nhập từ khóa
            } else {
                // Thực hiện AJAX request để tìm kiếm
                $.ajax({
                    url: '/admin/product/search', // URL để xử lý tìm kiếm
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // Bảo mật CSRF token
                        name: searchQuery // Từ khóa tìm kiếm
                    },
                    success: function(res) {
                        // Nếu không có kết quả
                        if (res.length === 0) {
                            $('#search-results').html('<p>Không tìm thấy kết quả nào.</p>');
                        } else {
                            // Tạo bảng HTML để hiển thị kết quả
                            let html = `
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Tên sản phẩm</th>
                                            <th>Giá</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                            `;
                            // Lặp qua từng sản phẩm và thêm vào bảng
                            res.forEach(function(product) {
                                html += `
                                    <tr>
                                        <td>${product.name}</td>
                                        <td>${product.price} VND</td>
                                        <td><button class="btn btn-primary">Chi tiết</button></td>
                                    </tr>
                                `;
                            });

                            html += `
                                    </tbody>
                                </table>
                            `;

                            // Hiển thị bảng kết quả tìm kiếm trong #search-results
                            $('#search-results').html(html);
                        }
                    },
                    error: function() {
                        // Nếu có lỗi xảy ra, hiển thị thông báo
                        $('#search-results').html('<p>Đã xảy ra lỗi. Vui lòng thử lại.</p>');
                    }
                });
            }
        });
    });
</script> --}}
