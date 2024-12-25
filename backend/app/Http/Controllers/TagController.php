<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();
        return response()->json($tags);
    }
    public function show($id)
    {
        $tag = Tag::find($id);
        return response()->json($tag, 200);
    }
    public function showBySlug($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        return response()->json($tag, 200);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:tags,name',
        ]);
        $slug = Str::slug($request->name);
        $tag = Tag::create([
            'name' => $request->name,
            'slug' => $slug,
        ]);


        return response()->json([
            $tag,
        ], 201);
    }
    public function destroyBySlug($slug)
    {
        // Tìm tag theo slug
        $tag = Tag::where('slug', $slug)->first();

        if (!$tag) {
            return response()->json([
                'message' => 'Tag not found',
            ], 404);
        }

        $tag->delete();

        return response()->json([
            'message' => 'Tag deleted successfully',
        ], 200);
    }
}
