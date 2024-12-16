@extends('admin.components.main')
@section('content')

<form action="/admin/product/edit/{{ $menu->id }}" method="post"enctype="multipart/form-data">
@csrf
    <div class="card-body">
        <div class="form-group">
            <label >ID</label>
            <input type="text"  name = "id" class="form-control" value="{{ $menu->id }}" >
        </div>
        <div class="form-group">
            <label >Tên sản Phẩm </label>
            <input type="text"  name = "name" class="form-control" value="{{$menu->name}}">
        </div>
        <div class="form-group">
            <label >Mô tả</label>
            <input type="text" class="form-control" name = "description" value="{{$menu->description}}">
        </div>
        <div class="form-group">
            <label >Gía tiền</label>
            <input type="text" class="form-control" name = "price" value="{{$menu->price}}">
        </div>
        <div class="form-group">
            <label >Số lượng</label>
            <input type="text" class="form-control" name = "stock" value="{{$menu->stock}}">
        </div>
        <div class="form-group">
            <label for="myfile">Ảnh sản phẩm:</label>
            <input type="file" id="myfile"  class="form-control" name = "image" >
            @if(isset($menu->image))
                <br>
                <img src="{{ asset('storage/' . $menu->image) }}" alt="Current Image" width="150">
            @endif
        </div>
        @csrf
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Sửa sản phẩm</button>
    </div>
</form>
@endsection 

<!-- @section('footer')
    <scrip>
        CKEDITOR.replace('content');
    </scrip>
@endsection -->
