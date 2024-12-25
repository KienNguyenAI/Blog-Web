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
        if (empty($validated['status'])) {
            $validated['status'] = 'archived';
        }
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
    public function getAllPosts($sort, Request $request)
    {
        $userId = $request->query('userId');
        // Tạo query cơ bản
        $query = Post::withCount('votes')
            ->with(['tag', 'user'])
            ->where('status', 'published');

        if ($sort === 'new') {
            $query->orderBy('created_at', 'desc');
        } elseif ($sort === 'top') {
            $query->orderBy('votes_count', 'desc');
        } elseif ($sort === "hot") {
            $query->orderBy('votes_count', 'desc');
            $query->orderBy('created_at', 'desc');
            $query->limit(20);
        }

        $posts = $query->get();

        if ($userId) {
            $savedPosts = \App\Models\SavePost::where('users_id', $userId)
                ->pluck('posts_id')
                ->toArray();

            $posts->each(function ($post) use ($savedPosts) {
                $post->is_saved = in_array($post->id, $savedPosts);
            });
        } else {
            $posts->each(function ($post) {
                $post->is_saved = false;
            });
        }

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
    public function getPostDetails($slug, $userId)
    {
        $post = Post::with(['tag', 'user'])
            ->withCount(['votes'])
            ->where('slug', $slug)
            ->firstOrFail();

        $isSaved = false;
        if ($userId) {
            // Kiểm tra trạng thái vote của user
            $userVote = \App\Models\Vote::where('users_id', $userId)
                ->where('posts_id', $post->id)
                ->first();
            $voteType = $userVote ? $userVote->vote_type : null;

            // Kiểm tra xem user có lưu bài viết không
            $savePost = \App\Models\SavePost::where('users_id', $userId)
                ->where('posts_id', $post->id)
                ->exists();
            $isSaved = $savePost;
        }

        return response()->json([
            'post' => $post,
            'user_vote' => $voteType,
            'saved' => $isSaved,
        ], 200);
    }
    public function getPost()
    {
        $posts = Post::withCount('votes')
            ->with(['tag', 'user'])
            ->orderByRaw("CASE WHEN status = 'archived' THEN 0 ELSE 1 END")
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($posts, 200);
    }
    public function update(Request $request, $slug)
    {
        $post = Post::where('slug', $slug)->first();

        if (!$post) {
            return response()->json([
                'message' => 'Bài viết không tồn tại.'
            ], 404);
        }

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

        $post->title = $validated['title'];
        $post->description = $validated['description'];
        $post->content = $validated['content'];
        $post->image = $validated['image'] ?? $post->image; // Giữ lại ảnh cũ nếu không cập nhật
        $post->status = $validated['status'];
        $post->users_id = $validated['users_id'];
        $post->tags_id = $validated['tags_id'];

        $post->save();

        return response()->json([
            'message' => 'Cập nhật bài viết thành công',
            'post' => $post,
        ], 200);
    }
    public function updatePost(Request $request, $id)
    {
        // Kiểm tra và validate dữ liệu
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

        // Tìm bài viết theo id
        $post = Post::find($id);

        // Nếu không tìm thấy bài viết, trả về lỗi
        if (!$post) {
            return response()->json(['error' => 'Bài viết không tồn tại'], 404);
        }

        // Cập nhật các trường dữ liệu
        $post->update($validated);

        return response()->json([
            'message' => 'Cập nhật bài viết thành công',
            'post' => $post,
        ], 200);
    }
}
