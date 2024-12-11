@extends('admin.layouts.front', ['main_page' => 'yes'])
@section('content')

    <style>
        .image-container img {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
            max-width: 100%;
            height: auto;
        }

        .card-img-top {
            max-height: 200px;
            object-fit: cover;
        }

        .callout-info {
            background-color: #f4f6f9;
            border-left: 5px solid #17a2b8;
        }

        .btn {
            margin: 5px;
        }
    </style>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><strong>{{ $post->title }}</strong></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('DetailsPost') }}">Post</a></li>
                            <li class="breadcrumb-item active">Post View</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <section class="content">
            <div class="container-fluid">
                <!-- Card Layout -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Post Details</h3>
                    </div>
                    <div class="card-body">
                        <!-- Images Grid Section -->
                        <div class="row mb-4">
                            <h4 class="ml-3">Images:</h4>
                            <div class="d-flex flex-wrap">
                                @php
                                    $images = explode(',', $post->images);
                                @endphp

                                @if(!empty($images) && $images[0] != '')
                                    @foreach($images as $image)
                                        <div class="col-md-4 mb-3">
                                            <div class="card">
                                                <img src="{{ asset($image) }}" alt="Post Image" class="img-fluid card-img-top">
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="ml-3">No images available for this post.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Videos Section -->
                        <div class="row mb-4">
                            <h4 class="ml-3">Videos:</h4>
                            <div class="d-flex flex-wrap">
                                @php
                                    $videos = explode(',', $post->video);
                                @endphp

                                @if(!empty($videos) && $videos[0] != '')
                                    @foreach($videos as $video)
                                        <div class="col-md-4 mb-3">
                                            <div class="card">
                                                <video class="card-img-top" controls>
                                                    <source src="{{ asset($video) }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="ml-3">No videos available for this post.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Content Section -->
                        <div class="row">
                            <div class="col-12">
                                <div class="callout callout-info">
                                    <h5><i class="fas fa-info-circle"></i> Content:</h5>
                                    <p>{{ $post->content }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Section -->
                        <div class="row mt-5">
                            <div class="col-md-6 text-left">
                                <strong>Posted By:</strong> {{ $post->user->name ?? 'Unknown' }}<br>
                                <strong>Last Updated At:</strong> {{ $post->updated_at->format('d-m-Y') }}
                            </div>
                            <div class="col-md-6 text-right">
                                <form action="{{ route('post.approve', $post->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-success">Approve</button>
                                </form>
                                <form action="{{ route('post.reject', $post->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-danger">Reject</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        // Your existing JavaScript goes here
    </script>

@endsection
