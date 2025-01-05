@extends('user.components.main')
@section('content')
<div class="container mt-5 pt-5 ">
    <!-- Tiêu đề -->
    <h1 class="text-center fw-bold mb-4">Liên Hệ Với Chúng Tôi</h1>
    
    <!-- Thông tin liên hệ -->
    <div class="row mb-5">
        <div class="col-md-6">
            <h3 class="fw-bold">Thông Tin Liên Hệ</h3>
            <p><strong>Địa chỉ:</strong> 56-70-72 Tây Sơn, Đống Đa, Hà Nội</p>
            <p><strong>Điện thoại:</strong> 0984918486 hoặc 0913576123</p>
            <p><strong>Email:</strong> contact@authenticshoes.com</p>
            <p><strong>Giờ làm việc:</strong> 9:00 AM - 9:00 PM (Thứ 2 - Chủ Nhật)</p>
        </div>
        <div class="col-md-6">
            <h3 class="fw-bold">Vị Trí Của Chúng Tôi</h3>
            <!-- Google Maps -->
            <div class="ratio ratio-16x9">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.8832192770014!2d105.77083131535855!3d21.038132892836872!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135abce2c5f343d%3A0x8d14a4bc71171fcd!2zNTYgVMOieSBTxqFuLCBLaMOhdCBMw6o!5e0!3m2!1svi!2s!4v1672339201234"
                    allowfullscreen=""
                    loading="lazy"></iframe>
            </div>
        </div>
    </div>

    {{-- <!-- Biểu mẫu liên hệ -->
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h3 class="fw-bold mb-4">Gửi Thông Điệp Cho Chúng Tôi</h3>
            <form>
                <div class="mb-3">
                    <label for="name" class="form-label">Họ và tên</label>
                    <input type="text" class="form-control" id="name" placeholder="Nhập họ và tên" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Nhập email của bạn" required>
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label">Chủ đề</label>
                    <input type="text" class="form-control" id="subject" placeholder="Nhập chủ đề" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Nội dung</label>
                    <textarea class="form-control" id="message" rows="5" placeholder="Nhập nội dung tin nhắn" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Gửi Tin Nhắn</button>
            </form>
        </div>
    </div> --}}
</div>
@endsection 