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
                <div class="col-md-11">
                    <form action=""  id="search-form">
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
                    <div id="search-results" class="mt-3">
                        <table class = "table table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>           
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Update</th>
                                </tr>
                            </thead>
                                @foreach($lists as $list)
                                    <tr>
                                        <td>{{$list->id}}</td>
                                        <td>
                                            <img class="card-img-top" src="/storage/{{$list->image}}" style="width:100px">
                                        </td>
                                        <td>{{$list->name}}</td>
                                        <td>{{$list->description}}</td>
                                        <td>{{$list->price}}</td>
                                        <td>{{$list->created_at}}</td>
                                        <td>
                                            <a href="{{ route('admin.product.details', $list->id) }}" class="btn btn-info btn-sm">Xem chi tiết</a>
                        
                                            <a class = "btn btn-primary btn-sm" href="/admin/product/edit/{{$list->id}}">
                                                <i class = "fas fa-edit"></i>
                                            </a>
                                            <a href ='/admin/product/delete/{{$list->id}}'class = "btn btn-danger btn-sm" onclick = "removeRow(' .$list->id .' \'admin/product/distroy/')">
                                                <i class = "fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>    
</div>
@endsection

