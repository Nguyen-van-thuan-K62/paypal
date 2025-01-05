<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;

class ManageCommentController extends Controller
{
    
    public function index(Request $request)
    {
        $searchTerm = $request->input('search'); // Search input

        // Query for fetching comments with related user and product
        $query = Comment::with(['user', 'product']);

        if ($searchTerm) {
            $query->whereHas('user', function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%$searchTerm%");
            })->orWhereHas('product', function ($q) use ($searchTerm) {
                $q->where('description', 'like', "%$searchTerm%");
            })->orWhere('content', 'like', "%$searchTerm%");
        }

        $allComment = $query->paginate(10);

        return view('admin.comment.index', [
            'title' => 'Danh sách các đánh giá ',
            'allComment' => $allComment,
            'searchTerm' => $searchTerm,
        ]);
    }

    // Edit a comment
    public function edit($id)
    {
        $comment = Comment::findOrFail($id);
        return view('admin.comment.edit', [
            'title' => 'Chỉnh sửa đánh giá',
            'comment' => $comment,
        ]);
    }

    // Update a comment
    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $comment = Comment::findOrFail($id);
        $comment->content = $request->input('content');
        $comment->save();

        return redirect()->route('admin.manage_comment.index')->with('success', 'Cập nhập đánh giá thành công!');
    }

    // Delete a comment
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect()->route('admin.manage_comment.index')->with('success', 'Xóa đánh giá thành công!');
    }
}
