<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Auth::user()->posts()->orderBy('created_at', 'desc')->get();
        return view('posts.index', compact('posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|max:300',
            'publish_at' => 'nullable|date|after:now',
        ]);

        Auth::user()->posts()->create($request->only('content', 'publish_at'));

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }
}
