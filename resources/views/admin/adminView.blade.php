@extends('admin.layouts.front',['main_page' => 'yes'])
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>View post Status</h1>
                    </div>
                </div>
            </div>
        </section>

        <div class="container">
            <div class="card" style="margin: 20px 0; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <div class="card-header bg-primary text-white text-center" style="border-radius: 8px 8px 0 0;">
                    <h3 class="card-title">{{ $post->title }}</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Blog Content -->
                        <div class="col-md-8 blog-posts">
                            <div class="post-blog">
                                <div class="blog-image" style="margin-top: 20px">
                                    @php
                                        $images = $post->images ? explode(',', $post->images) : [];
                                    @endphp

                                    @if(!empty($images) && isset($images[0]))
                                        <img
                                            src="{{ asset(trim($images[0])) }}"
                                            alt="Post Image"
                                            class="img-fluid"
                                            style="width: 100%; max-width: 1000px; max-height: 300px; object-fit: cover; border: 1px solid #ddd; border-radius: 8px;">
                                    @else
                                        <p>No images available for this post.</p>
                                    @endif
                                </div>

                                <div class="blog-content" style="margin-top: 20px;">
                                    <span class="small-text">Tags:</span>
                                    <a href="#" rel="tag">{{ $post->subCategory->category_name }}</a>

                                    <p style="margin-top: 15px;">{!! nl2br($post->content) !!}</p>
                                </div>
                                <div class="blog-image">
                                    <div class="row justify-content-center mt-4">
                                        @if(isset($post->video) && !empty($post->video))
                                            @foreach(explode(',', $post->video) as $video)
                                                <div class="col-md-6 mb-3">
                                                    <video class="w-100" controls style="width: 100%; max-width: 2700px; max-height: 400px; object-fit: cover; border: 1px solid #ddd; border-radius: 8px;">
                                                        <source src="{{ asset(trim($video)) }}" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="ml-3">No videos available for this post.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="col-md-4">
                            <div class="sidebar">
                                <div class="sidebar-widget">
                                    <h5 class="widget-title">Comments</h5>
                                    <h3>{{ $comments->count() }} Comments</h3>
                                    <div class="blog-comments-content">
                                        @forelse($comments as $comment)
                                            <div class="media" style="margin-bottom: 20px; border-bottom: 1px solid #ddd; padding-bottom: 15px;">
                                                <div class="media-body">
                                                    <div class="media-heading" style="margin-bottom: 10px;">
                                                        <h4 style="margin: 0;">{{ $comment->name }}</h4>
                                                        <span style="font-size: 12px; color: #777;">{{ $comment->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <p style="margin: 10px 0;">{{ $comment->comment }}</p>
                                                    <!-- Approve and Reject Buttons -->
                                                    <div style="display: flex; justify-content: flex-end; gap: 10px;">
                                                        <form action="{{ route('comment.approve', $comment->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm" style="padding: 5px 15px; font-size: 14px; border-radius: 4px;">Approve</button>
                                                        </form>
                                                        <form action="{{ route('comment.reject', $comment->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger btn-sm" style="padding: 5px 15px; font-size: 14px; border-radius: 4px;">Reject</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <p>No comments yet.</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-center" style="background-color: #f8f9fa; border-radius: 0 0 8px 8px;">
                    <p class="text-muted">Last updated: {{ $post->updated_at->format('d-m-Y') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
