<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class AdminController extends Controller
{
    public function adminDashboard()
    {
        $posts=Post::all();
        return view('admin.dashboard',compact('posts')); // Adjust the path to match your view
    }

    public function admincategory()
    {
        $categories = Category::where('parent_id', NULL)->get();
        return view('admin.category', compact('categories'));
    }

    public function storecategory(Request $request)
{
    $validated = $request->validate([
        'category_name' => 'required|string|max:255',
        'parent_id' => 'nullable|exists:category,id',
    ]);

    Category::create([
        'category_name' => $validated['category_name'],
        'parent_id' => $validated['parent_id'] ?? null,
    ]);

    return redirect()->route('admin.category')->with('success', 'Category created successfully!');
}


    public function editCategory($id)
   {
    $category = Category::findOrFail($id);
    return view('admin.edit_category', compact('category'));
   }


   public function updateCategory(Request $request, $id)
   {
    $request->validate([
        'category_name' => 'required|string|max:255',
    ]);

    $category = Category::findOrFail($id);
    $category->category_name = $request->category_name;
    $category->save();

    return redirect()->route('admin.category')->with('success', 'Category updated successfully.');
   }

  public function deleteCategory($id)
   {
      $category = Category::findOrFail($id);
      $this->deleteSubCategories($category);
      $category->delete();

      return redirect()->route('admin.category')->with('success', 'Category deleted successfully.');
   }
   protected function deleteSubCategories(Category $category)
{
    foreach ($category->subCategories as $subCategory) {
        $this->deleteSubCategories($subCategory); // Recursively delete subcategories
        $subCategory->delete();
    }
}




// sub category controllers

public function subCategory($id)
 {
    $mainCategory = Category::findOrFail($id);
    $subCategories = Category::where('parent_id', $id)->get();
    return view('admin.sub_category', compact('mainCategory', 'subCategories'));
 }

public function storeSubCategory(Request $request)
 {
    $request->validate([
        'category_name' => 'required|string|max:255',
        'subcategory_name' => 'required|string|max:255',
    ]);

    Category::create([
        'category_name' => $request->subcategory_name,
        'parent_id' => $request->category_id,
    ]);

    return redirect()->route('admin.subcategory', ['id' => $request->category_id])->with('success', 'Subcategory added successfully!');
 }

public function editSubCategory($id)
 {
    $subCategory = Category::findOrFail($id);
    $mainCategory = Category::findOrFail($subCategory->parent_id);
    return view('admin.edit_subcategory', compact('subCategory', 'mainCategory'));
 }

public function updateSubCategory(Request $request, $id)
{
    $request->validate([
        'category_name' => 'required|string|max:255',
    ]);

    $subCategory = Category::findOrFail($id);
    $subCategory->category_name = $request->category_name;
    $subCategory->save();

    return redirect()->route('admin.subcategory', ['id' => $subCategory->parent_id])->with('success', 'Subcategory updated successfully.');
 }

public function deleteSubCategory($id)
{
    $subCategory = Category::findOrFail($id);
    $parentId = $subCategory->parent_id;
    $subCategory->delete();

    return redirect()->route('admin.subcategory', ['id' => $parentId])->with('success', 'Subcategory deleted successfully.');
}




// post blog

public function adminPost()
{
    $mainCategories = Category::where('parent_id', Null)->get();
    // $posts = $this->getPosts();

    return view('admin.admin_post', compact('mainCategories'));
}

public function fetchSubCategories(Request $request)
{
    $subCategories = Category::where('parent_id', $request->parent_id)->get();
    return response()->json(['subCategories' => $subCategories]);
}


public function storePost(Request $request)
{


   // Validate the request
    $validatedData = $request->validate([
        'mainctg_id' => 'required',
        'subctg_id' => 'required',
        'title' => 'required',
        'content' => 'required',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'videos.*' => 'nullable|mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4|max:51200'
    ]);

    // Save the post details
    $post = new Post();
    $post->mainctg_id = $request->mainctg_id;
    $post->subctg_id = $request->subctg_id;
    $post->title = $request->title;
    $post->content = $request->content;
    $post->status = $request->status ?? null;
    $post->u_id = Auth::id();

    // Initialize paths
    $imagePaths = [];
    $videoPaths = [];


    // Save images
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/images'), $imageName);
            $imagePaths[] = 'uploads/images/' . $imageName;
        }
    }

    // Save videos
    if ($request->hasFile('videos')) {
        foreach ($request->file('videos') as $video) {
            $videoName = uniqid() . '.' . $video->getClientOriginalExtension();
            $video->move(public_path('uploads/videos'), $videoName);
            $videoPaths[] = 'uploads/videos/' . $videoName;
        }
    }

    // Store paths in the database as comma-separated values
    $post->images = implode(',', $imagePaths);
    $post->video = implode(',', $videoPaths);

    $post->save();

    return redirect()->back()->with('success', 'Post created successfully!');
}









// post view
public function DetailsPost()
{
    $posts = $this->getPosts();
    return view('admin.detailspost', compact('posts'));
}

public function getPosts()
{
    return Post::with(['mainCategory', 'user'])
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function ($post) {
            return [
                'id' => $post->id,
                'name' => $post->user->name ?? 'Unknown', // Get user name
                'main_category_name' => $post->mainCategory->category_name ?? 'No Category', // Get main category
                'title' => $post->title,
                'status' => $post->status,
            ];
        });
}

public function viewPost($id)
{
    $post = Post::with('user')->findOrFail($id);
    return view('admin.view_post', compact('post'));
}

public function approvePost($id)
{
    $post = Post::findOrFail($id);
    \Log::info('Approving post', [
        'post_id' => $post->id,
        'current_status' => $post->status,
        'new_status' => 'Approve' // Make sure to match the enum case
    ]);
    $post->status = 'Approve'; // Use 'Approve' with correct case
    $post->save();

    return redirect()->back()->with('success', 'Post approved successfully.');
}

public function rejectPost($id)
{
    $post = Post::findOrFail($id);
    $post->status = 'Reject'; // Use 'Reject' with correct case
    $post->save();

    return redirect()->back()->with('success', 'Post rejected successfully.');
}


public function editPost($id)
{
    $post = Post::find($id);

    if (!$post) {
        return redirect()->route('admin.post')->with('error', 'Post not found.');
    }

    $mainCategories = Category::where('parent_id', null)->get();
    return view('admin.edit_post', compact('post', 'mainCategories'));
}

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
    return redirect()->route('DetailsPost')->with('success', 'Post and associated files deleted successfully');
}
public function approveComment($id)
{

    $comments = Comment::findOrFail($id);

    \Log::info('Approving post', [
        'comments_id' => $comments->id,
        'current_status' => $comments->status,
        'new_status' => 'Approve' // Make sure to match the enum case
    ]);
    $comments->status = 'Approve'; // Use 'Approve' with correct case
    $comments->save();

    return redirect()->back()->with('success', 'Post approved successfully.');

}
    public function rejectComments($id)
    {
        $comments = Comment::findOrFail($id);
        $comments->status = 'Reject'; // Use 'Reject' with correct case
        $comments->save();

        return redirect()->back()->with('success', 'Post rejected successfully.');
    }
}

