<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SavePost;

class SavePostController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'users_id' => 'required|exists:users,id',
            'posts_id' => 'required|exists:posts,id',
        ]);

        $existingSavePost = SavePost::where('users_id', $request->users_id)
            ->where('posts_id', $request->posts_id)
            ->first();

        if ($existingSavePost) {
            $existingSavePost->delete();

            return response()->json([
                'message' => 'Bản ghi đã tồn tại và đã bị xóa.',
                'data' => $existingSavePost
            ]);
        } else {
            $savePost = SavePost::create([
                'users_id' => $request->users_id,
                'posts_id' => $request->posts_id,
            ]);

            return response()->json([
                'message' => 'Thêm dữ liệu thành công.',
                'data' => $savePost
            ]);
        }
    }
}
