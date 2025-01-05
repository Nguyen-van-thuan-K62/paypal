@extends('admin.components.main')
@section('content')

<form action="/admin/carousel/edit/{{ $menu->id }}" method="post"enctype="multipart/form-data">
@csrf
    <div class="card-body">
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
        <button type="submit" class="btn btn-primary">Sửa hình ảnh</button>
    </div>
</form>
@endsection 

