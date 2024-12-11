<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class UserViewController extends Controller
{
    //
    public function fullBlogView($id)
    {
        // Find the post by id, or return 404 if not found
        $post = Post::findOrFail($id);

        // Get recent posts ordered by updated_at (descending) and limit to 3
        $recentPosts = Post::orderBy('updated_at', 'desc')->take(3)->get();

        // Load all comments related to this post, ordered by created_at
        $comments = $post->comments()->orderBy('created_at', 'desc')->get(); // Remove pagination

        // Return the view with the post, recent posts, and comments data
        return view('reBlog', [
            'post' => $post,
            'recentPosts' => $recentPosts,
            'comments' => $comments,  // Pass all comments to the view without pagination
        ]);
    }




    public function store(Request $request, $postId)
    {
        // Validate the incoming comment data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'comment' => 'required|string|max:500',
        ]);

        // Get the post_id from the form input (or use the one from the route)
        $post_id = $request->input('post_id', $postId); // Fallback to the route parameter if not provided in form

        // Find the associated post, throw a 404 if not found
        $post = Post::findOrFail($post_id);

        // Create the new comment
        Comment::create([
            'post_id' => $post->id, // This links the comment to the correct post
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'comment' => $request->input('comment'),
        ]);

        // Redirect back to the blog post page with a success message
        return redirect()->route('fullBlog.view', ['id' => $post->id])
            ->with('success', 'Your comment has been added successfully.');
    }

    public function BlogPage(Request $request)
    {
        $threshold = 10;

        // Fetch the three most recent posts
        $recentPosts = Post::orderBy('updated_at', 'desc')->take(3)->get();

        // Handle posts fetching based on threshold
        $query = Post::with('user')->latest();
        $postCount = $query->count();

        if ($postCount > $threshold) {
            $allPosts = $query->paginate(10);
        } else {
            $allPosts = $query->get();
        }

        // Ensure $post is assigned to a single post for comments
        $post = $query->first();
        $comments = $post ? $post->comments()->orderBy('created_at', 'desc')->get() : collect();
        $commentCount = $post ? $post->comments()->count() : 0;

        // Check if the request is an AJAX request
        if ($request->ajax()) {
            return view('partials.posts', compact('allPosts'));
        }

        // Return the view with posts, recent posts, comments, and comment count
        return view('page', [
            'post' => $allPosts,
            'recentPosts' => $recentPosts,
            'comments' => $comments,
            'commentCount' => $commentCount,
        ]);
    }
    public function adminPost($id){
        // Find the post by id, or return 404 if not found
        $post = Post::findOrFail($id);

        // Get recent posts ordered by updated_at (descending) and limit to 3
        $recentPosts = Post::orderBy('updated_at', 'desc')->take(3)->get();

        // Load all comments related to this post, ordered by created_at
        $comments = $post->comments()->orderBy('created_at', 'desc')->get(); // Remove pagination

        // Return the view with the post, recent posts, and comments data
        return view('admin.adminView', [
            'post' => $post,
            'recentPosts' => $recentPosts,
            'comments' => $comments,  // Pass all comments to the view without pagination
        ]);

    }


}
