<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follower;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function follow(Request $request)
    {
        $followerId = $request->input('follower');
        $followingId = $request->input('following');

        $existingFollow = Follower::where('follower_id', $followerId)
            ->where('following_id', $followingId)
            ->first();

        if ($existingFollow) {
            return response()->json(['message' => 'You are already following this user'], 400);
        }
        $follow = Follower::create([
            'follower_id' => $request->input('follower'),
            'following_id' => $request->input('following')
        ]);
        if ($follow) {
            return response()->json(['message' => 'Followed successfully', 'data' => $follow], 201);
        } else {
            return response()->json(['message' => 'Failed to follow'], 500);
        }
    }
    public function checkFollow(Request $request)
    {
        $followerId = $request->input('follower');
        $followingId = $request->input('following');

        $existingFollow = Follower::where('follower_id', $followerId)
            ->where('following_id', $followingId)
            ->exists();

        return response()->json([
            'message' => $existingFollow ? 'Already following' : 'Not following',
            'isFollowing' => $existingFollow
        ], 200);
    }
    public function unfollow(Request $request)
    {
        $followerId = $request->input('follower');
        $followingId = $request->input('following');


        $existingFollow = Follower::where('follower_id', $followerId)
            ->where('following_id', $followingId)
            ->first();

        if ($existingFollow) {
            $existingFollow->delete();
            return response()->json(['message' => 'Unfollowed successfully'], 200);
        } else {
            return response()->json(['message' => 'Follow relationship not found'], 404);
        }
    }
    public function getFollowedAuthors(Request $request)
    {
        $followerId = $request->input('follower');

        $followedAuthors = Follower::where('follower_id', $followerId)
            ->pluck('following_id'); 
        return response()->json([
            'followedAuthors' => $followedAuthors
        ], 200);
    }
}