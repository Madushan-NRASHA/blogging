@extends('admin.layouts.front',['main_page' > 'yes'])
@section('content')


<body>

    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Edit Sub category</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{route('admin.category')}}">Category</a></li>
              <li class="breadcrumb-item"><a href="{{route('admin.subcategory', $mainCategory->id)}}">{{ $mainCategory->category_name }}</a></li>
              <li class="breadcrumb-item active">Edit Subcategory</li>
              </ol>
            </div>
          </div>
        </div>
      </section>

  {{-- category form --}}
      <section class="content">
          <div class="card card-info">
              <div class="card-header">
                  <h3 class="card-title">Edit Subcategory Form</h3>
              </div>

              <form class="form-horizontal" method="POST" action="{{ route('update.subcategory', $subCategory->id) }}">
                @csrf
                  <div class="card-body">
                    <div class="form-group row">
                        <label for="categoryName" class="col-sm-2 col-form-label">Main Category Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="categoryName" name="main_category_name" value="{{ $mainCategory->category_name }}" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="subcategoryName" class="col-sm-2 col-form-label">Subcategory Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="subcategoryName" name="category_name" value="{{ $subCategory->category_name }}" required>
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
@endsection
