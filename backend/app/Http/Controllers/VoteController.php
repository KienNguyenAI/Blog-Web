<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    /**
     * Thêm hoặc cập nhật vote
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vote_type' => 'required|in:up,down',
            'post_id' => 'required|exists:posts,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $userId = $validated['user_id'];

        $existingVote = Vote::where('users_id', $userId)
            ->where('posts_id', $validated['post_id'])
            ->first();

        if ($existingVote) {

            if ($existingVote->vote_type === $validated['vote_type']) {
                $existingVote->delete();

                return response()->json([
                    'message' => 'Vote has been removed.',
                    'type' => null,
                ]);
            }


            $existingVote->update([
                'vote_type' => $validated['vote_type'],
            ]);

            return response()->json([
                'message' => 'Vote has been updated.',
                'vote' => $existingVote,
            ]);
        }


        $vote = Vote::create([
            'users_id' => $userId,
            'posts_id' => $validated['post_id'],
            'vote_type' => $validated['vote_type'],
        ]);

        return response()->json([
            'message' => 'Vote has been added.',
            'vote' => $vote,

        ]);
    }

    /**
     * Lấy tổng số vote cho một bài viết
     */
    public function getVotes(Request $request, $postId)
    {
        $upVotes = Vote::where('posts_id', $postId)
            ->where('vote_type', 'up')
            ->count();

        $downVotes = Vote::where('posts_id', $postId)
            ->where('vote_type', 'down')
            ->count();

        return response()->json([
            'up_votes' => $upVotes,
            'down_votes' => $downVotes,
        ]);
    }
    public function getUserUpvotes(Request $request, $userId)
    {

        if (!$userId) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $upvotedPosts = Vote::where('users_id', $userId)
            ->where('vote_type', 'up')
            ->with('post')
            ->get()
            ->pluck('post');

        return response()->json($upvotedPosts);
    }
}