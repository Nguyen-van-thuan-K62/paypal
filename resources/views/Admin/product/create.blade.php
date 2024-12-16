@extends('admin.components.main')
@section('content')

<form action="/admin/product/create" method="post" enctype="multipart/form-data">

    <div class="card-body">

        <div class="form-group">
            <label >Tên sản Phẩm </label>
            <input type="text"  name = "name" class="form-control">
        </div>

        <div class="form-group">
            <label >Mô tả</label>
            <textarea class="form-control" name = "description"></textarea>
        </div>

        <div class="form-group">
            <label >Gía tiền</label>
            <textarea class="form-control" name = "price"></textarea>
        </div>

        <div class="form-group">
            <label >Số lượng</label>
            <textarea class="form-control" name = "stock"></textarea>
        </div>

        <div class="form-group">
            <label for="myfile">Ảnh sản phẩm:</label>
            <input type="file" id="myfile" class="form-control" name = "image" required multiple><br><br>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
    </div>
    @csrf
</form>
@endsection 

@section('footer')
    <scrip>
        CKEDITOR.replace('content');
    </scrip>
@endsection 
