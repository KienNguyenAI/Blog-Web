<?php

namespace App\Http\Controllers;

use App\Models\UserBio;
use Illuminate\Http\Request;

class UserBioController extends Controller
{
    public function getUserBioByUserId($userId)
    {
        $userBio = UserBio::with('user')->where('users_id', $userId)->first();

        if (!$userBio) {
            return response()->json([
                'message' => 'UserBio not found for the given user_id.'
            ], 404);
        }

        return response()->json(
            $userBio,
        );
    }
}
