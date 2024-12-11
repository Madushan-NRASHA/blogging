<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Store a new comment
    public function store(Request $request, $postId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
//            'website' => 'nullable|url|max:255',
            'comment' => 'required|string|max:500',
        ]);

        // Create the comment
        Comment::create([
            'post_id' => $postId,
            'name' => $request->name,
            'email' => $request->email,
            'website' => $request->website,
            'comment' => $request->comment,
        ]);

        return redirect()->route('reBlog', $postId)->with('success', 'Comment added successfully');
    }

    // Display comments for a specific post (not strictly needed, but you could separate concerns)
    public function show($postId)
    {
        $post = Post::findOrFail($postId);
        $comments = $post->comments()->latest()->get();

        return view('reBlog', compact('post', 'comments'));
    }
}
