<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Đơn Hàng</title>
    <!-- Liên kết với Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mb-4">Chi Tiết Đơn Hàng #12345</h2>
                <!-- Thông tin đơn hàng -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Thông Tin Đơn Hàng</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Mã Đơn Hàng:</strong> #12345</li>
                            <li class="list-group-item"><strong>Ngày Đặt Hàng:</strong> 2024-12-25</li>
                            <li class="list-group-item"><strong>Trạng Thái Đơn Hàng:</strong> Đã Thanh Toán</li>
                            <li class="list-group-item"><strong>Phương Thức Thanh Toán:</strong> Chuyển Khoản Ngân Hàng</li>
                        </ul>
                    </div>
                </div>

                <!-- Thông tin khách hàng -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title">Thông Tin Khách Hàng</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Tên Khách Hàng:</strong> Nguyễn Văn A</li>
                            <li class="list-group-item"><strong>Email:</strong> nguyen.vana@example.com</li>
                            <li class="list-group-item"><strong>Địa Chỉ Giao Hàng:</strong> 123 Đường ABC, Quận 1, TP.HCM</li>
                            <li class="list-group-item"><strong>Số Điện Thoại:</strong> 0987654321</li>
                        </ul>
                    </div>
                </div>

                <!-- Danh sách sản phẩm -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title">Danh Sách Sản Phẩm</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tên Sản Phẩm</th>
                                    <th>Số Lượng</th>
                                    <th>Giá</th>
                                    <th>Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Sản phẩm A</td>
                                    <td>2</td>
                                    <td>500,000 VND</td>
                                    <td>1,000,000 VND</td>
                                </tr>
                                <tr>
                                    <td>Sản phẩm B</td>
                                    <td>1</td>
                                    <td>1,200,000 VND</td>
                                    <td>1,200,000 VND</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tổng kết đơn hàng -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title">Tổng Kết Đơn Hàng</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Tổng Tiền Sản Phẩm:</strong> 2,200,000 VND</li>
                            <li class="list-group-item"><strong>Chi Phí Vận Chuyển:</strong> 50,000 VND</li>
                            <li class="list-group-item"><strong>Giảm Giá:</strong> 100,000 VND</li>
                            <li class="list-group-item"><strong>Tổng Thanh Toán:</strong> 2,150,000 VND</li>
                        </ul>
                    </div>
                </div>

                <!-- Tình trạng vận chuyển -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title">Tình Trạng Vận Chuyển</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Vận Chuyển:</strong> Đang Giao Hàng</p>
                        <p><strong>Ngày Giao Dự Kiến:</strong> 2024-12-28</p>
                    </div>
                </div>

                <!-- Nút quay lại -->
                <div class="mt-4">
                    <a href="javascript:history.back()" class="btn btn-secondary">Quay Lại</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Liên kết với Bootstrap JS và Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
