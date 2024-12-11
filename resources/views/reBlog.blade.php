@extends('frontend.layout.front')

@section('content')
    <div class="first-widget parallax" id="blogId" style="margin-top: 0px">
        <div class="parallax-overlay">
            <div class="container pageTitle">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
{{--                        <h2 class="page-title">Blog Single</h2>--}}
                    </div>
                    <div class="col-md-6 col-sm-6 text-right">
{{--                        <span class="page-location">Home / Blog Single</span>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <!-- Blog Content -->
            <div class="col-md-8 blog-posts">
                <div class="post-blog">
                    <h3 class="text-primary text-center fw-bold" style="margin-top: -10px">{{ $post->title }}</h3>


                    <div class="blog-image" style="margin-top: 50px">
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

                    <div class="blog-content">
                        <span class="small-text">Tags:</span>
                        {{--                            <a href="#" rel="tag">{{$post->subCategory->name}}</a>--}}
                        <a href="#" rel="tag">  {{ $post->subCategory->category_name }}</a>

                        <p>{!! nl2br($post->content) !!}</p>
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
{{--                                    <p class="ml-3">No videos available for this post.</p>--}}
                                @endif
                            </div>
                        </div>

                        <div class="tag-items">
{{--                            <span class="small-text">Tags:</span>--}}
{{--                            <a href="#" rel="tag">{{$post->subCategory->name}}</a>--}}
{{--                            <a href="#" rel="tag">  {{ $post->subCategory->category_name }}</a>--}}
{{--                            <a href="#" rel="tag">education</a>--}}
                            <span class="meta-date"><a href="#">{{ $post->updated_at->format('d-m-Y') }}</a></span>
                            <span class="meta-author"><a href="#">{{ $post->user ? $post->user->name : 'Unknown' }}</a></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="blog-author" class="clearfix">
                            <a href="#" class="blog-author-img pull-left">
{{--                                <img src="images/includes/author.png" alt="">--}}
                            </a>
{{--                            for fututure devolopment--}}
{{--                            <div class="blog-author-info">--}}
{{--                                <h4 class="author-name"><a href="#">Candy Sharp</a> <button class="btn btn-success" disabled>pending</button></h4>--}}
{{--                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam, quod, doloremque, quia cum maiores commodi consequatur dolore et dolores omnis officiis minus dolor ex quae incidunt veritatis.</p>--}}
{{--                            </div>--}}
                        </div>
                    </div> <!-- /.col-md-12 -->
                </div> <!-- /.row -->
                <!-- Comments Section -->
                <div id="blog-comments" class="blog-post-comments">
                    <!-- Count only approved comments -->
                    <h3>{{ $comments->where('status', 'Approve')->count() }} Comments</h3>
                    <div class="blog-comments-content">
                        <!-- Loop through comments and show only approved ones -->
                        @forelse($comments->where('status', 'Approve') as $comment)
                            <div class="media">
                                <div class="pull-left">
                                    {{-- Avatar image if needed --}}
                                    {{-- <img class="media-object" src="{{ asset('images/includes/default-avatar.png') }}" alt="Avatar" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;"> --}}
                                </div>

                                <div class="media-body">
                                    <div class="media-heading">
                                        <h4>{{ $comment->name }}</h4> <!-- Display the user's name -->
                                        <a href="#">
                                            <span>{{ $comment->created_at->diffForHumans() }}</span> <!-- Show time ago -->
                                        </a>
                                    </div>
                                    <p>{{ $comment->comment }}</p> <!-- Display the content of the comment -->
                                </div>
                            </div>
                        @empty
                            <!-- If no approved comments exist, show this message -->
                            <p>No comments yet. Be the first to comment!</p>
                        @endforelse
                    </div>
                </div>



                <!-- Comment Form -->
                <div class="comment-form">
                    <h3>Leave a comment</h3>
                    <form action="{{ route('comments.store', $post->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}"> <!-- Hidden field for post_id -->
                        <!-- Hidden field for post_id -->
                        <!-- Hidden input for post_id -->
                        <div class="row">
                            <div class="col-md-4">
                                <p><label for="name-id">Your Name:</label><input type="text" id="name-id" name="name" required></p>
                            </div>
                            <div class="col-md-4">
                                <p><label for="email-id">Email Address:</label><input type="email" id="email-id" name="email" required></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p><label for="comment">Your Comment:</label><textarea name="comment" id="comment" rows="5" required></textarea></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <input class="mainBtn" type="submit" value="Submit Comment">
                            </div>
                        </div>
                    </form>
                </div>
{{--                <div class="comment-form">--}}
{{--                    <h3>Leave a comment</h3>--}}
{{--                    <form action="{{ route('comments.store', $post->id) }}" method="POST">--}}
{{--                        @csrf--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-4">--}}
{{--                                <p><label for="name-id">Your Name:</label><input type="text" id="name-id" name="name" required></p>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4">--}}
{{--                                <p><label for="email-id">Email Address:</label><input type="email" id="email-id" name="email" required></p>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4">--}}
{{--                                <p><label for="site-id">Your Site:</label><input type="text" id="site-id" name="website"></p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-12">--}}
{{--                                <p><label for="comment">Your Comment:</label><textarea name="comment" id="comment" rows="5" required></textarea></p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-12">--}}
{{--                                <input class="mainBtn" type="submit" value="Submit Comment">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
            </div>

            <!-- Sidebar -->
            <div class="col-md-4">
                <div class="sidebar">
                    <!-- Recent Posts -->
                    <div class="sidebar-widget">
                        <h5 class="widget-title">Recent Posts</h5>
                        @foreach ($recentPosts as $recent)
                            @if($recent->status === 'Approve')
                            @php
                                $recentImages = $recent->images ? explode(',', $recent->images) : [];
                            @endphp

                            <div class="last-post clearfix">
                                @if(!empty($recentImages) && isset($recentImages[0]))
                                    <img src="{{ asset(trim($recentImages[0])) }}" alt="Recent Post Image" style="width: 100px; height: 100px; object-fit: cover;">
                                @else
                                    <p>No image</p>
                                @endif
                                <div class="content">
                                    <span>{{ $recent->updated_at->format('d F Y') }}</span>
                                    <h4><a href="{{ route('fullBlog.view', ['id' => $recent->id]) }}">{{ $recent->title }}</a></h4>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Categories -->
{{--                    <div class="sidebar-widget">--}}
{{--                        <h5 class="widget-title">Categories</h5>--}}
{{--                        <ul>--}}
{{--                            <li><a href="#">Standard</a></li>--}}
{{--                            <li><a href="#">Audio</a></li>--}}
{{--                            <li><a href="#">Video</a></li>--}}
{{--                            <li><a href="#">Branding</a></li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
@endsection
