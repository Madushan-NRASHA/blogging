<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserViewController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthoruserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [UserViewController::class, 'BlogPage'])->name('BlogPage');






Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [UserController::class, 'register']);
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login-form');

Route::post('/login', [UserController::class, 'login'])->name('login');

//Auth::routes();
Route::get('/get-customer-data', [UserController::class, 'getCustomerDataByMonth']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth');




// admin dashboard pages controller



    Route::get('/admin/category', [AdminController::class, 'admincategory'])->name('admin.category');
    Route::post('/admin/category', [AdminController::class, 'storecategory'])->name('store.category');
    Route::get('/admin/category/edit/{id}', [AdminController::class, 'editCategory'])->name('edit.category');
    Route::post('/admin/category/update/{id}', [AdminController::class, 'updateCategory'])->name('update.category');
    Route::get('/admin/category/delete/{id}', [AdminController::class, 'deleteCategory'])->name('delete.category');


    // sub category routes
    Route::get('/admin/category/subcategory/{id}', [AdminController::class, 'subCategory'])->name('admin.subcategory');
    Route::post('/admin/category/subcategory', [AdminController::class, 'storeSubCategory'])->name('store.subcategory');
    Route::get('/admin/category/subcategory/edit/{id}', [AdminController::class, 'editSubCategory'])->name('edit.subcategory');
    Route::post('/admin/category/subcategory/update/{id}', [AdminController::class, 'updateSubCategory'])->name('update.subcategory');
    Route::get('/admin/category/subcategory/delete/{id}', [AdminController::class, 'deleteSubCategory'])->name('delete.subcategory');
//    Route::get('/fullBlog/view',[UserViewController::class,'fullBlogView'])->name('fullBlog.view');use App\Http\Controllers\UserViewController;

    Route::get('/fullBlog/view/{id}', [UserViewController::class, 'fullBlogView'])->name('fullBlog.view');
    Route::get('/adminView/post/{id}', [UserViewController::class, 'adminPost'])->name('adminView.post');
        //  blog post form
    Route::post('/posts/{postId}/comments', [UserViewController::class, 'store'])->name('comments.store');

    Route::get('user/dsahboard/{id}',[AuthoruserController::class,'userDashBoard'])->name('user.dashboard');
    Route::get('user/post',[AuthoruserController::class,'userPost'])->name('user.post');
    Route::get('user/detailes',[AuthoruserController::class,'UserPostDetail'])->name('user.detailes');
    Route::get('user/userPostview/{id}',[AuthoruserController::class,'UserPostview'])->name('user.userPostview');
    Route::get('user/post/view/{id}',[AuthoruserController::class,'viewPost'])->name('user.postview');
    Route::get('user/post/edit/{id}',[AuthoruserController::class,'editPost'])->name('user.editpost');
    Route::get('user/post/delete/{id}',[AuthoruserController::class,'deletePost'])->name('user.deletepost');
    Route::post('user/post/update/{id}',[AuthoruserController::class,'updatePost'])->name('user.updatepost');
//// Route to show a post with its comments
//Route::get('/posts/{postId}', [CommentController::class, 'show'])->name('posts.show');


    Route::middleware(['auth'])->group(function () {

        Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::get('/admin/post', [AdminController::class, 'adminPost'])->name('admin.post');
        Route::post('/admin/post/store', [AdminController::class, 'storePost'])->name('admin.post.store');
        Route::get('/admin/subcategories', [AdminController::class, 'fetchSubCategories'])->name('admin.subcategories');

        Route::get('/admin/DetailsPost', [AdminController::class, 'DetailsPost'])->name('DetailsPost');

        Route::get('/admin/post/view/{id}', [AdminController::class, 'viewPost'])->name('view.post');
        Route::post('/admin/post/approve/{id}', [AdminController::class, 'approvePost'])->name('post.approve');
        Route::post('/admin/post/reject/{id}', [AdminController::class, 'rejectPost'])->name('post.reject');
        Route::post('admin/comments/approve/{id}', [AdminController::class, 'approveComment'])->name('comment.approve');
        Route::post('admin/comments/reject/{id}', [AdminController::class, 'rejectComments'])->name('comment.reject');

        Route::get('/admin/post/edit/{id}', [AdminController::class, 'editPost'])->name('edit.post');
        Route::post('/admin/post/update/{id}', [AdminController::class, 'updatePost'])->name('update.post');
        Route::get('/admin/post/delete/{id}', [AdminController::class, 'deletePost'])->name('delete.post');




    });






