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
    public function storeUserBio(Request $request, $userId)
    {
        // Validation các trường dữ liệu
        $validated = $request->validate([
            'bio_description' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'current_job' => 'nullable|string|max:100',
            'education' => 'nullable|string|max:100',
            'current_location' => 'nullable|string|max:255',
            'hometown' => 'nullable|string|max:255',
        ]);

        // Kiểm tra nếu UserBio đã tồn tại, thì update, nếu chưa thì tạo mới
        $userBio = UserBio::where('users_id', $userId)->first();

        if ($userBio) {
            // Nếu đã có UserBio thì update
            $userBio->update($validated);
            return response()->json([
                'message' => 'UserBio updated successfully.',
                'userBio' => $userBio
            ], 200);
        } else {
            $userBio = new UserBio($validated);
            $userBio->users_id = $userId;
            $userBio->save();

            return response()->json([
                'message' => 'UserBio created successfully.',
                'userBio' => $userBio
            ], 201);
        }
    }
}
