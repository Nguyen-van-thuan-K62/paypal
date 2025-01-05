@extends('admin.components.main')

@section('content')
<div class="container mt-4">
    <h2>Chỉnh sửa bình luận</h2>

    <form action="{{ route('admin.manage_comment.update', $comment->id) }}" method="POST">
        @csrf
      
        <div class="mb-3">
            <label for="content" class="form-label">Nội dung bình luận</label>
            <textarea name="content" id="content" class="form-control" rows="4">{{ $comment->content }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.manage_comment.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
