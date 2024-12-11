@extends('user.layouts.front',['main_page' => 'yes'])

@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>User Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Post</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Alert messages (static examples) -->
        <div class="alert alert-danger" style="display: none;">
            <ul>
                <li>Error message here</li>
            </ul>
        </div>
        <div class="alert alert-success" style="display: none;">
            Success message here
        </div>

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
                                    @foreach ($posts as $post)
                                        <tr>
                                            <td>{{ $post->id }}</td>
                                            <td>{{ $post->user->name }}</td>
                                            <td>{{ $post->title }}</td>
                                            <td>{{ $post->created_at->format('d-m-Y') }}</td>
                                            <td>
                                            <span class="btn btn-success btn-sm">
                                                {{ $post->status ?? 'Pending' }}
                                            </span>
                                            </td>
                                            <td class="action-icons">
                                                <a href="{{ route('user.userPostview', $post->id) }}" class="text-warning">
                                                <span class="btn btn-primary">
                                                    <i class="far fa-eye"></i> <span>View</span>
                                                </span>
                                                </a>
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

@endsection
