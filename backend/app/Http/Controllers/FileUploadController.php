<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {

        $request->validate([
            'image' => 'required|mimes:jpg,jpeg,png,gif,webp|max:2048', // Giới hạn kích thước 2MB
        ]);

        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $path = $file->storeAs('post', time() . '-' . $file->getClientOriginalName(), 'public');


            return response()->json(['filePath' => asset('storage/' . $path)], 200);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
    public function deleteImage(Request $request)
    {
        $filePath = $request->input('filePath'); // Đường dẫn file (URL đầy đủ)

        if (!$filePath) {
            return response()->json(['message' => 'File path is required'], 400);
        }

        // Chuyển URL công khai thành đường dẫn nội bộ
        $localPath = str_replace(url('/storage'), public_path('storage'), $filePath);

        if (file_exists($localPath)) {
            unlink($localPath); // Xóa file
            return response()->json(['message' => 'File deleted successfully']);
        }

        return response()->json(['message' => 'File not found'], 404);
    }
}
