@extends('admin.components.main')
@section('content')

<form action="/admin/carousel/create" method="post" enctype="multipart/form-data">

    <div class="card-body">
        <div class="form-group">
            <label for="myfile">Ảnh động:</label>
            <input type="file" id="myfile" class="form-control" name = "image" required multiple><br><br>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Thêm hình ảnh</button>
    </div>
    @csrf
</form>
@endsection 

@section('footer')
    <scrip>
        CKEDITOR.replace('content');
    </scrip>
@endsection 
