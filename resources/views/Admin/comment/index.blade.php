@extends('admin.components.main')

@section('content')
<div class="container mt-4">
    <h2>Quản lý bình luận</h2>

    <!-- Search Form -->
    <form action="{{ route('admin.manage_comment.index') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo tên người dùng, sản phẩm hoặc nội dung" value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </div>
        </div>
    </form>

    <!-- Comments Table -->
    <table class="table table-striped">
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
        <tbody>
            @forelse($allComment as $comment)
                <tr>
                    <td>{{ $comment->id }}</td>
                    <td>{{ $comment->user->name }}</td>
                    <td>{{ $comment->product->description }}</td>
                    <td>{{ $comment->content }}</td>
                    <td>{{ $comment->created_at }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('admin.manage_comment.edit', $comment->id) }}">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.manage_comment.delete', $comment->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Không tìm thấy bình luận nào</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    {{ $allComment->links() }}
</div>
@endsection
