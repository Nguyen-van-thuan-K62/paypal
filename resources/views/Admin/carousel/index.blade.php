@extends('admin.components.main')

@section('content')
<table class = "table table-striped">
    <thead>
        <tr>
            <th>Id</th>           
            <th>Image</th>
            <th>Update</th>

        </tr>
    </thead>
        @foreach($lists as $list)
            <tr>
                <td>{{$list->id}}</td>
                <td>
                    <img class="card-img-top" src="/storage/{{$list->image}}" style="width:100px">
                </td>
                <td>{{$list->created_at}}</td>
                <td>
                    <a class = "btn btn-primary btn-sm" href="/admin/carousel/edit/{{$list->id}}">
                        <i class = "fas fa-edit"></i>
                    </a>
                    <a href ='/admin/carousel/delete/{{$list->id}}'class = "btn btn-danger btn-sm" onclick = "removeRow(' .$list->id .' \'admin/carousel/distroy/')">
                        <i class = "fas fa-trash"></i>
                    </a>
                </td>
            </tr>
            
        @endforeach
        <!-- {{$lists->links()}} -->
        
</table>

@endsection 