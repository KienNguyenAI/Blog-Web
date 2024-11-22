<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function store(Request $request)
    {


        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'users_id' => 'required|exists:users,id',
        ], [
            'title.required' => 'Tiêu đề không được để trống',
            'content.required' => 'Nội dung không được để trống',
            'users_id.required' => 'ID người dùng không hợp lệ',
            'users_id.exists' => 'Người dùng không tồn tại',
        ]);

        $post = Post::create($validated);
        return response()->json(['message' => 'Post created successfully', 'post' => $post], 201);
    }
}
