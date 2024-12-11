@extends('frontend.layout.front')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
{{--                        <h1>Blog Posts</h1>--}}
                    </div>
                </div>
            </div>
        </section>

        <!-- Parallax Section -->
        <div class="first-widget parallax" id="blog" style="margin-top: 0px">
            <div class="parallax-overlay">
                <div class="container pageTitle">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
{{--                            <h2 class="page-title">Blog</h2>--}}
                        </div>
                        <div class="col-md-6 col-sm-6 text-right">
{{--                            <span class="page-location">Home / Blog</span>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Blog Content -->
        <div class="container">
            <div class="row">
                <!-- Blog Posts Section -->
                <div class="col-md-8 blog-posts">
                    <div class="row">
                        <div class="col-md-12">
                            @forelse($post as $singlePost)
                                @if($singlePost->status === 'Approve')
                                <div class="post-blog">
                                    <!-- Post Image -->
                                    <div class="blog-image">
                                        <div class="row justify-content-center">
                                            @php
                                                $images = $singlePost->images ? explode(',', $singlePost->images) : [];
                                            @endphp

                                            @if(!empty($images) && isset($images[0]))
                                                <div class="col-md-8 mb-3">
                                                    <div class="card">
                                                        <img
                                                            src="{{ asset(trim($images[0])) }}"
                                                            alt="Post Image"
                                                            class="img-fluid card-img-top"
                                                            style="width: 100%; max-height: 300px; object-fit: cover; border: 1px solid #ddd; border-radius: 8px;">
                                                    </div>
                                                </div>
                                            @else
                                                <p class="ml-3">No images available for this post.</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Post Content -->
                                    <div class="blog-content">
                                        <span class="meta-date"><a href="#">{{ $singlePost->updated_at->format('d-m-Y') }}</a></span>
                                        <span class="meta-comments"><a href="#">{{ $singlePost->comments()->count() }} Comments</a></span>
                                        <span class="meta-author">
                                        <a href="#">{{ $singlePost->user ? $singlePost->user->name : 'Unknown' }}</a>
                                    </span>

                                        <h3>{{ $singlePost->title }}</h3>

                                        <p class="light-text">
                                            {{ Str::limit($singlePost->content, 150) }}
                                        </p>

                                        <p>
                                            {{ Str::limit($singlePost->content, 250) }}
                                            <a href="{{ route('fullBlog.view', ['id' => $singlePost->id]) }}">Continue Reading...</a>
                                        </p>
                                    </div>
                                </div>
                                @endif
                            @empty
                                <p>No posts available.</p>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        <div class="col-md-12">
                            @if($post instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                <ul class="pages">
                                    {{ $post->links() }}
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar Section -->
                <div class="col-md-4">
                    <div class="sidebar">
                        <!-- Recent Posts Widget -->
                        <div class="sidebar-widget">
                            <h5 class="widget-title">Recent Posts</h5>
                            @forelse ($recentPosts as $recent)
                                @if($recent->status === 'Approve')
                                @php
                                    $recentImages = $recent->images ? explode(',', $recent->images) : [];
                                @endphp

                                <div class="last-post clearfix">
                                    @if(!empty($recentImages) && isset($recentImages[0]))
                                        <img src="{{ asset(trim($recentImages[0])) }}" alt="Recent Post Image" style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <p>No image</p>
                                    @endif
                                    <div class="content">
                                        <span>{{ $recent->updated_at->format('d F Y') }}</span>
                                        <h4><a href="{{ route('fullBlog.view', ['id' => $recent->id]) }}">{{ $recent->title }}</a></h4>
                                    </div>
                                </div>
                                @endif
                            @empty
                                <p>No recent posts available.</p>
                            @endforelse
                        </div>

                        <!-- Categories Widget -->
{{--                        <div class="sidebar-widget">--}}
{{--                            <h5 class="widget-title">Categories</h5>--}}
{{--                            <div class="row categories">--}}
{{--                                <div class="col-md-6">--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Standard</a></li>--}}
{{--                                        <li><a href="#">Audio</a></li>--}}
{{--                                        <li><a href="#">Video</a></li>--}}
{{--                                        <li><a href="#">Branding</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-6">--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">iOS Design</a></li>--}}
{{--                                        <li><a href="#">Business</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
