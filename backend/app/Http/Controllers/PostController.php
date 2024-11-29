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
            'tags_id' => 'required',
        ], [
            'title.required' => 'Tiêu đề không được để trống',
            'title.min' => 'Tiêu đề phải ít nhất 10 kí tự',
            'content.required' => 'Nội dung không được để trống',
            'users_id.required' => 'ID người dùng không hợp lệ',
            'users_id.exists' => 'Người dùng không tồn tại',
            'status.required' => 'Trạng thái bài viết không được để trống',
            'status.in' => 'Trạng thái bài viết không hợp lệ',
            'tags_id.required' => "Bạn cần chọn danh mục cho bài viết",
        ]);
        if (empty($validated['image'])) {
            $validated['image'] = 'http://127.0.0.1:8000/storage/post/default.webp';
        }
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
    public function showBySlug($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return response()->json($post, 200);
    }
    public function destroy($slug)
    {
        $post = Post::where('slug', $slug)->first();
        $post->delete();
        return response()->json([
            'message' => 'Bài viết đã được xóa thành công'
        ], 200);
    }
    public function index()
    {
        $post = Post::all();
        return response()->json($post);
    }
    public function getAllPosts($sort)
    {
        // Tạo query cơ bản
        $query = Post::withCount('votes')
            ->with(['tag', 'user']);

        if ($sort === 'new') {
            $query->orderBy('created_at', 'desc');
        } elseif ($sort === 'top') {
            $query->orderBy('votes_count', 'desc');
        } elseif ($sort === "hot") {
            $query->orderBy('votes_count', 'desc');
            $query->orderBy('created_at', 'desc');
            $query->limit(20);
        } else {
            $userId = (int)$sort;

            $user = \App\Models\User::find($userId);

            if (!$user) {
                return response()->json([
                    'message' => 'Người dùng không tồn tại.'
                ], 404);
            }

            $query->whereHas('savedByUsers', function ($query) use ($userId) {
                $query->where('users_id', $userId);
            });
        }

        $posts = $query->get();

        return response()->json($posts, 200);
    }



    public function topVotedPosts()
    {
        $posts = Post::withCount('votes')
            ->with(['tag', 'user'])
            ->orderBy('votes_count', 'desc')
            ->limit(10)
            ->get();

        return response()->json($posts, 200);
    }
    public function topVotedPostsByTag($tagSlug) // Nhận tham số 'tagSlug' từ URL
    {
        $tag = \App\Models\Tag::where('slug', $tagSlug)->first();

        if (!$tag) {
            return response()->json([
                'message' => 'Tag không hợp lệ hoặc không tồn tại.'
            ], 404);
        }

        $posts = Post::withCount('votes')
            ->with(['tag', 'user'])
            ->where('tags_id', $tag->id)
            ->orderBy('votes_count', 'desc')
            ->limit(6)
            ->get();

        if ($posts->isEmpty()) {
            return response()->json([
                'message' => 'Không có bài viết nào với tag này.'
            ], 404);
        }

        return response()->json($posts, 200);
    }
    public function getPostsByUsername($username)
    {
        $user = \App\Models\User::where('username', $username)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Người dùng không tồn tại.'
            ], 404);
        }

        $posts = Post::where('users_id', $user->id)
            ->with(['tag'])
            ->orderBy('created_at', 'desc')
            ->get();


        if ($posts->isEmpty()) {
            return response()->json([
                'message' => 'Không có bài viết nào của người dùng này.'
            ], 404);
        }


        return response()->json($posts, 200);
    }
}
