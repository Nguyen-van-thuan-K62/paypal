<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $productId)
    {
        // Validate nội dung comment
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        // Lưu comment
        Comment::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'content' => $request->input('content'),
        ]);

        return redirect()->back()->with('success', 'Comment has been added successfully!');
    }
}
