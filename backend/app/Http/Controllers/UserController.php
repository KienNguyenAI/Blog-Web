<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follower;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(string $id)
    {
        $user = User::find($id);

        return response()->json($user);
    }

    public function getUserByUsername($username)
    {
        $user = User::where('username', $username)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $followingCount = Follower::where('follower_id', $user->id)->count() ?? 0;


        $followerCount = Follower::where('following_id', $user->id)->count() ?? 0;

        return response()->json([
            $user,
            'following_count' => $followingCount,
            'follower_count' => $followerCount
        ]);
    }
}
