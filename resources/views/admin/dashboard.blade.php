@extends('admin.layouts.front',['main_page' => 'yes'])
@section('content')

    <body>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Post</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Post Table</h3>
                            </div>
                            <div class="card-body">

                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Post ID</th>
                                        <th>Author Name</th>
                                        <th>Post Title</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>View Post</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($posts as $post)
                                        <tr>
                                            <td>{{ $post['id'] }}</td>
                                            <td>{{ $post->user ? $post->user->name : 'Unknown' }}</td>
                                            <td>{{ $post['title'] }}</td>
                                            <td>{{ $post->updated_at->format('d-m-Y') }}</td>
                                            <td>
                                             <span class="btn btn-{{ $post['status'] === 'Approve' ? 'success' : ($post['status'] === 'Pending' ? 'warning' : 'secondary') }} btn-sm">
        {{ $post['status'] ?? 'pending' }}
    </span>

                                            </td>


                                            <td class="action-icons">
                                                <a href="{{  route('adminView.post', ['id' => $post->id]) }}" class="text-warning">
                                                    <span class="btn btn-primary"><i class="far fa-eye"></i> <span>View</span></span>
                                                </a>
{{--                                                <a href="{{ route('edit.post', $post['id']) }}" class="text-warning">--}}
{{--                                                    <span class="btn btn-warning"><i class="fas fa-edit"></i> <span>Edit</span></span>--}}
{{--                                                </a>--}}
{{--                                                <a href="{{ route('delete.post', $post['id']) }}" class="text-danger" onclick="confirmDelete(event)">--}}
{{--                                                    <span class="btn btn-danger"><i class="fas fa-trash"></i> <span>Delete</span></span>--}}
{{--                                                </a>--}}
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Post ID</th>
                                        <th>Author Name</th>
                                        <th>Post Title</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>View Post</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    </body>

@endsection
