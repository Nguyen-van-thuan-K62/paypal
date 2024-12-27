@extends('admin.components.main')

@section('content')
<table class = "table table-striped">
    <thead>
        <tr>
            <th>Id</th>           
            <th>Tên người dùng</th>
            <th>Tên sản phẩm</th>
            <th>Đánh giá</th>
            <th>Thời gian</th>
            <th>Công cụ</th>
        </tr>
    </thead>
        @foreach($allComment as $comment)
            <tr>
                <td>{{$comment->id}}</td>
                <td>{{$comment->user->name}}</td>
                <td>{{$comment->product->description}}</td>
                <td>{{$comment->content}}</td>
                <td>{{$comment->created_at}}</td>
                <td>
                    <a class = "btn btn-primary btn-sm" href="">
                        <i class = "fas fa-edit"></i>
                    </a>
                    <a href =''class = "btn btn-danger btn-sm" onclick = "removeRow(' .$list->id .' \'admin/product/distroy/')">
                        <i class = "fas fa-trash"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        
</table>

@endsection 