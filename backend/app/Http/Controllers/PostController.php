<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|min:10',
            'description' => 'nullable|string',
            'content' => 'required',
            'image' => 'nullable|string',
            'status' => 'required|in:draft,published,archived',
            'users_id' => 'required|exists:users,id',
        ], [
            'title.required' => 'Tiêu đề không được để trống',
            'title.min' => 'Tiêu đề phải ít nhất 10 kí tự',
            'content.required' => 'Nội dung không được để trống',
            'users_id.required' => 'ID người dùng không hợp lệ',
            'users_id.exists' => 'Người dùng không tồn tại',
            'status.required' => 'Trạng thái bài viết không được để trống',
            'status.in' => 'Trạng thái bài viết không hợp lệ',
        ]);

        $post = Post::create($validated);
        $postId = $post->id;
        return response()->json([
            'message' => 'Tạo bài viết thành công',
            'post_id' => $postId,
            'post' => $post,
        ], 201);
    }
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return response()->json($post, 200);
    }
}
