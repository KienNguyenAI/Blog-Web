<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

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
}
