@extends('Admin.components.main')
@section('content')
<h3>Danh sách người dùng</h3>
<table class = "table">
    <thead>
        <tr>
            <th>id</th>
            <th>name</th>           
            <th>email</th>
            <th>pasword</th>
    
        </tr>
    </thead>
        @foreach($users as $user)
            <tr>
                
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->password}}</td>
               
                <td>
                    <a class = "btn btn-primary btn-sm" href="/admin/menu/update/{{$user->id}}">
                        <i class = "fas fa-edit"></i>
                    </a>
                    <a href ='/admin/delete/{{$user->id}}'class = "btn btn-danger btn-sm" onclick = "removeRow(' .$user->id .' \'admin/menu/distroy/')" >
                        <i class = "fas fa-trash"></i>
                    </a>
                </td>
            </tr>
            
        @endforeach
      
        
</table>

@endsection 
