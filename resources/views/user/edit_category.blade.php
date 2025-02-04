@extends('admin.layouts.front',['main_page' > 'yes'])
@section('content')



  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Category Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.category')}}">Category</a></li>
                <li class="breadcrumb-item active">Edit Category</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->

    <section class="content">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Edit Category Form</h3>
            </div>

            <form class="form-horizontal" method="POST" action="{{ route('update.category', $category->id) }}">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="categoryName" class="col-sm-2 col-form-label">Edit Category Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="categoryName" name="category_name" placeholder="" required>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Update</button>
                    <button type="button" class="btn btn-default float-right" onclick="window.history.back()">Cancel</button>
                </div>
            </form>
        </div>
    </section>

    </div>

</body>
@endsection

