<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class AuthoruserController extends Controller
{
    public function userDashBoard($id)
    {
        // Find the user by ID or return 404 if not found

        // Find the user by ID or return 404 if not found
        $user = User::findOrFail($id);

        // Fetch posts authored by this user, ordered by creation date
        // Update 'user_id' to 'u_id' to match the correct column in your database
        $posts = Post::where('u_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Return the view with user details and posts
        return view('user.userDashboard', [
            'user' => $user,
            'posts' => $posts,
        ]);
    }



    public function userPost()
   {
       $mainCategories = Category::where('parent_id', Null)->get();
       return view('user.user_post', compact('mainCategories'));
   }
    public function UserPostDetail()
    {
        // Fetch posts for the currently authenticated user
        $posts = Post::where('u_id', auth()->id()) // Filter by logged-in user ID
        ->orderBy('created_at', 'desc') // Order by creation date
        ->get();

        // Return the view with posts data
        return view('user.detailspost', compact('posts'));
    }

    public function UserPostview($id){

       $post = Post::findOrFail($id);

       // Get recent posts ordered by updated_at (descending) and limit to 3
       $recentPosts = Post::orderBy('updated_at', 'desc')->take(3)->get();

       // Load all comments related to this post, ordered by created_at
       $comments = $post->comments()->orderBy('created_at', 'desc')->get(); // Remove pagination

       // Return the view with the post, recent posts, and comments data
       return view('user.userView', [
           'post' => $post,
           'recentPosts' => $recentPosts,
           'comments' => $comments,  // Pass all comments to the view without pagination
       ]);
   }
    public function viewPost($id)
    {
        $post = Post::with('user')->findOrFail($id);
        return view('user.view_post', compact('post'));
    }
    public function editPost($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return redirect()->route('user.edit_post')->with('error', 'Post not found.');
        }

        $mainCategories = Category::where('parent_id', null)->get();
        return view('user.edit_post', compact('post', 'mainCategories'));
    }
    public function deletePost($id)
    {
        // Find the post
        $post = Post::findOrFail($id);

        // Delete associated images
        if (!empty($post->images)) {
            $images = explode(',', $post->images);
            foreach ($images as $image) {
                $imagePath = public_path($image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
        }

        // Delete associated videos
        if (!empty($post->video)) {
            $videos = explode(',', $post->video);
            foreach ($videos as $video) {
                $videoPath = public_path($video);
                if (file_exists($videoPath)) {
                    unlink($videoPath);
                }
            }
        }

        // Delete the post from the database
        $post->delete();

        // Redirect with success message
        return redirect()->route('user.detailes')->with('success', 'Post and associated files deleted successfully');
    }
//    public function editPost($id)
//    {
//        $post = Post::find($id);
//
//        if (!$post) {
//            return redirect()->route('admin.post')->with('error', 'Post not found.');
//        }
//
//        $mainCategories = Category::where('parent_id', null)->get();
//        return view('user.edit_post', compact('post', 'mainCategories'));
//    }
    public function updatePost(Request $request, $id) {
        $request->validate([
            'title' => 'required|string|max:255',
            'mainctg_id' => 'required|exists:category,id',
            'subctg_id' => 'nullable|exists:category,id',
            'content' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'videos.*' => 'nullable|mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4|max:51200',
        ]);

        $post = Post::findOrFail($id);

        // Update post details
        $post->title = $request->title;
        $post->mainctg_id = $request->mainctg_id;
        $post->subctg_id = $request->subctg_id;
        $post->content = $request->content;

        // Handle images
        if ($request->hasFile('images')) {
            // Delete old images
            if (!empty($post->images)) {
                $oldImages = explode(',', $post->images);
                foreach ($oldImages as $oldImage) {
                    $oldImagePath = public_path(trim($oldImage));
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
            }

            // Save new images
            $images = [];
            foreach ($request->file('images') as $image) {
                $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/images'), $imageName);
                $images[] = 'uploads/images/' . $imageName;
            }

            // Update images in database
            $post->images = implode(',', $images);
        }

        // Handle videos
        if ($request->hasFile('videos')) {
            // Delete old videos
            if (!empty($post->video)) {
                $oldVideos = explode(',', $post->video);
                foreach ($oldVideos as $oldVideo) {
                    $oldVideoPath = public_path(trim($oldVideo));
                    if (file_exists($oldVideoPath)) {
                        unlink($oldVideoPath);
                    }
                }
            }

            // Save new videos
            $videos = [];
            foreach ($request->file('videos') as $video) {
                $videoName = uniqid() . '.' . $video->getClientOriginalExtension();
                $video->move(public_path('uploads/videos'), $videoName);
                $videos[] = 'uploads/videos/' . $videoName;
            }

            // Update videos in database
            $post->video = implode(',', $videos);
        }

        $post->save();

        return redirect()->route('user.detailes')->with('success', 'Post updated successfully');
    }
}
