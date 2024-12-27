<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;

class ManageCommentController extends Controller
{
    public function index()
    {
        $allComment =Comment::all();
        return view('admin.comment.index',[
            'title' => 'Danh sách các đánh giá ',
            'allComment' => $allComment
        ]);
    }
}
