@extends('admin.layouts.front',['main_page' > 'yes'])
@section('content')



<body>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Category Table</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Category</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

     {{-- Display success message --}}
     @if(session('success'))
     <div class="alert alert-success">
         {{ session('success') }}
     </div>
    @endif

{{-- category form --}}
    <section class="content">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Category Form</h3>
            </div>

            <form class="form-horizontal" method="POST" action="{{ route('store.category') }}">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="categoryName" class="col-sm-2 col-form-label">Category Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="categoryName" name="category_name" placeholder="Enter category name" required>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Save</button>
                    <button type="button" class="btn btn-default float-right" onclick="window.history.back()">Cancel</button>
                </div>
            </form>
        </div>
    </section>




    <!--category table -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
            </div>

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Main Category Table</h3>
              </div>
              <div class="card-body">

                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Category Name</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($categories as $category)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                        <td>{{ $category->category_name }}</td>
                        <td class="action-icons">
                          <a href="{{ route('admin.subcategory', $category->id) }}" class="text-primary">
                            <span class="btn btn-primary"><i class="fas fa-plus"></i> <span>Subcategory</span></span>
                          </a>
                          <a href="{{ route('edit.category', $category->id) }}" class="text-warning">
                            <span class="btn btn-warning"><i class="fas fa-edit"></i> <span>Edit</span></span>
                          </a>
                          <a href="{{ route('delete.category', $category->id) }}" class="text-danger" onclick="confirmDelete(event)">
                            <span class="btn btn-danger"><i class="fas fa-trash"></i> <span>Delete</span></span>
                          </a>
                        </td>
                  </tr>
                  @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Category Name</th>
                    <th>Action</th>
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
