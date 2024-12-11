
@extends('admin.layouts.front',['main_page' > 'yes'])
@section('content')

<style>

#drag-drop-area {
        border: 2px dashed #ccc;
        border-radius: 5px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
    }
    #drag-drop-area.dragover {
        background-color: #f0f0f0;
        border-color: #999;
    }
    #drag-drop-video-area{
        border: 2px dashed #ccc;
        border-radius: 5px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
    }

</style>



<body>
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Post Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Blog Post</li>
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


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Post Details</h3>
              </div>


               <form method="POST" action="{{ route('admin.post.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="u_id" value="{{ Auth::id() }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="exampleInputTitle">Title</label>
                                <input type="text" name="title" class="form-control" id="exampleInputTitle" placeholder="Enter title">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Main Category</label>
                                <select class="form-control" style="width: 100%;" id="main_category" name="mainctg_id">
                                    <option value="">Select Main Category</option>
                                    @foreach($mainCategories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Sub Category:</label>
                                <select class="form-control" style="width: 100%;" id="sub_category" name="subctg_id">
                                    <option value="">Select Sub Category</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                    <div class="form-group">
                    <label>Post Content</label>
                    <textarea class="form-control" rows="3" placeholder="Enter ..." name="content"></textarea>
                    </div>


                    </div>



                  <div class="form-group">
                    <label>Upload Images</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="exampleInputFile" name="images[]" multiple>
                            <label class="custom-file-label" for="exampleInputFile">Choose files</label>
                        </div>
                    </div>
                    <div id="drag-drop-area" class="mt-3">
                        <p>Drag and drop files here or click to select files</p>
                    </div>
                    <div id="imagePreview" class="row mt-3"></div>
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Videos</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile" name="videos[]" multiple>
                        <label class="custom-file-label" for="exampleInputFile">Choose videos</label>
                      </div>
                    </div>
                    <div id="drag-drop-video-area" class="mt-3">
                        <p>Drag and drop videos here or click to select files</p>
                    </div>
                </div>


                </div>
                </div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Save</button>
                  {{-- <button type="submit" class="btn btn-info">Save</button> --}}
                </div>
              </form>
            </div>
          </div>
    </section>

</div>
</body>





<script>
     $(document).ready(function() {
        // Initialize Select2 Elements
        $('.select2').select2();

        // Date picker
        $('#reservationdate').datetimepicker({
            format: 'L'
        });

        // Filter sub-categories based on main category selection
        $('#main_category').change(function() {
            var mainCategoryId = $(this).val();
            $('#sub_category').val('');
            $('#sub_category option').each(function() {
                var parentId = $(this).data('parent');
                if (mainCategoryId == parentId) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Image preview before uploading
        $('#images').change(function() {
            $('#image_preview').html('');
            var totalFiles = this.files.length;
            for (var i = 0; i < totalFiles; i++) {
                var file = this.files[i];
                var reader = new FileReader();
                reader.onload = function(event) {
                    $('#image_preview').append('<img src="'+event.target.result+'" class="img-thumbnail" width="100">');
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize the file input element
        document.getElementById('exampleInputFile').addEventListener('change', function(event) {
            var files = event.target.files;
            var previewContainer = document.getElementById('imagePreview');
            previewContainer.innerHTML = ''; // Clear the previous previews

            Array.from(files).forEach(function(file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-thumbnail');
                    img.style.width = '150px';
                    img.style.height= '200px';
                    img.style.margin = '5px';
                    previewContainer.appendChild(img);
                }
                reader.readAsDataURL(file);
            });
        });
    });
    </script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#main_category').change(function() {
            var mainCategoryId = $(this).val();
            if (mainCategoryId) {
                $.ajax({
                    url: '{{ route("admin.subcategories") }}',
                    type: 'GET',
                    data: { parent_id: mainCategoryId },
                    success: function(response) {
                        $('#sub_category').empty();
                        $('#sub_category').append('<option value="">Select Sub Category</option>');
                        $.each(response.subCategories, function(index, category) {
                            $('#sub_category').append('<option value="' + category.id + '">' + category.category_name + '</option>');
                        });
                    }
                });
            } else {
                $('#sub_category').empty();
                $('#sub_category').append('<option value="">Select Sub Category</option>');
            }
        });
    });
</script>



{{-- newww --}}
<script>

    document.addEventListener('DOMContentLoaded', function() {
    const dropArea = document.getElementById('drag-drop-area');
    const fileInput = document.getElementById('exampleInputFile');
    const imagePreview = document.getElementById('imagePreview');
    let files = [];

    // Function to handle file selection
    function handleFiles(newFiles) {
        // Prevent duplicate files from being added
        newFiles = Array.from(newFiles).filter(file => {
            return !files.some(existingFile => existingFile.name === file.name && existingFile.size === file.size);
        });

        files = [...files, ...newFiles]; // Update files array with new files
        updateImagePreview();
        updateFileInput(); // Update the file input field to hold the new files
    }

    // Update image preview
    function updateImagePreview() {
        imagePreview.innerHTML = '';
        files.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('img-thumbnail', 'mr-2', 'mb-2');
                img.style.width = '150px';
                img.style.height = '200px';

                const removeBtn = document.createElement('button');
                removeBtn.textContent = 'Remove';
                removeBtn.classList.add('btn', 'btn-sm', 'btn-danger', 'mt-1');
                removeBtn.onclick = function() {
                    files.splice(index, 1); // Remove the specific file from the array
                    updateImagePreview();
                    updateFileInput(); // Update file input after removal
                };

                const imgContainer = document.createElement('div');
                imgContainer.classList.add('d-inline-block', 'text-center', 'mr-2', 'mb-2');
                imgContainer.appendChild(img);
                imgContainer.appendChild(removeBtn);

                imagePreview.appendChild(imgContainer);
            }
            reader.readAsDataURL(file); // Read the file to create the preview
        });
    }

    // Update file input with all selected files
    function updateFileInput() {
        const dataTransfer = new DataTransfer();
        files.forEach(file => {
            dataTransfer.items.add(file); // Add all files to DataTransfer
        });
        fileInput.files = dataTransfer.files; // Set file input's files to the updated DataTransfer files
    }

    // File Input change event
    fileInput.addEventListener('change', function(e) {
        handleFiles(e.target.files); // Handle files when selected via input
    });

    // Drag and Drop events
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false);
    });

    function highlight() {
        dropArea.classList.add('dragover');
    }

    function unhighlight() {
        dropArea.classList.remove('dragover');
    }

    dropArea.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const newFiles = dt.files;
        handleFiles(newFiles); // Handle dropped files
    }

    // Click to select files
    dropArea.addEventListener('click', () => fileInput.click());
});

    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        let dropArea = document.getElementById('drag-drop-video-area');
        let fileInput = document.getElementById('exampleInputFile');
        let fileList = document.createElement('ul');  // Create a list to display file names
        dropArea.appendChild(fileList);

        // Prevent default behaviors for drag and drop
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false)
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        // Highlight drop area on drag
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.classList.add('highlight');
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.classList.remove('highlight');
        });

        // Handle file selection via drag-and-drop or file input change
        dropArea.addEventListener('drop', handleFiles, false);
        fileInput.addEventListener('change', handleFiles, false);

        function handleFiles(e) {
            let files;
            if (e.type === 'drop') {
                files = e.dataTransfer.files;
            } else {
                files = fileInput.files;
            }

            fileList.innerHTML = '';  // Clear the list before adding new files
            [...files].forEach(file => {
                let listItem = document.createElement('li');
                listItem.textContent = file.name;  // Display file name
                fileList.appendChild(listItem);
            });

            // Assign the selected or dropped files to the file input field
            fileInput.files = files;
        }
    });
    </script>
@endsection






















