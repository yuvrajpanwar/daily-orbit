@extends('admin/admin-layout/admin-app')

@push('css')
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <style type="text/css">
        .error {
            color: red;
        }

        #alert-success {
            transition-duration: 0.3s;
            transition-timing-function: ease-in-out;
        }

        .close-button {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            color: #333;
            text-decoration: none;
        }

        /* Add styles for Quill editor */
        .ql-editor {
            min-height: 200px;
        }

        .ql-container {
            font-size: 16px;
        }
    </style>
@endpush

@section('content') <div class="container-fluid mb-4">
        <div class="row">
            <div class="col-12 d-flex">
                <a href="{{ route('admin.posts') }}"><button class="btn btn-primary"> <i
                    class="fe fe-16 fe-arrow-left"></i>Back</button></a>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h3 class="page-title">Add New Post </h3>
            </div>
        </div>
    </div>
   

    <div class="container-fluid mb-4">

        @if (session('success'))
            <div class="alert alert-success show col-lg-7" id="alert-success">
                <a data-toggle="collapse" href="#alert-success" role="button" aria-expanded="true"
                    aria-controls="alert-success" class="btn-link close-button">X</a>
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">

            <div class="card col-md-6">

                <div class="card-body">

                    <form id="postForm" method="POST" action="{{ route('admin.store-post') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">

                            <!-- Category -->
                            <div class="mb-3 w-100">
                                <label>Category :</label>
                                <select name="category_id" id="category_id"
                                    class="form-control @error('category_id') is-invalid @enderror" required>
                                    <option value="" disabled class="text-center">--------Select Category--------
                                    </option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Title -->
                            <div class="mb-3 w-100">
                                <label>Title :</label>
                                <input type="text" class="form-control w-100 @error('title') is-invalid @enderror"
                                    name="title" id="title" value="{{ old('title') }}" required maxlength="100">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>   
                            
                            <!-- Description -->
                            <div class="mb-3 w-100">
                                <label>Description :</label><br>
                                <small>(Tip : Start with an image of 9:16 ratio)</small>
                                <!-- Hidden textarea to store Quill content -->
                                <input type="hidden" name="description" id="description">
                                <!-- Quill editor container -->
                                <div id="editor-container" style="height: 500px;"
                                    class="form-control @error('description') is-invalid @enderror">
                                    {!! old('description') ?? '<br><br><br><br>' !!}
                                </div>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>     
                            
                            <!-- Date -->
                            <div class="mb-3 w-100">
                                <label>Date :</label>
                                <input type="date" class="form-control w-100 @error('date') is-invalid @enderror"
                                    name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Author -->
                            <div class="mb-3 w-100">
                                <label>Author :</label>
                                <input type="text" class="form-control w-100 @error('author') is-invalid @enderror"
                                    name="author" id="author" value="{{ old('author') }}" required maxlength="100">
                                @error('author')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                         
                        </div>

                        <!-- Submit Button -->
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit">Add Post</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>

    </div>
@endsection

@push('js')
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill-image-resize-module@3.0.0/image-resize.min.js"></script>
    <script>
        function imageHandler() {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.click();

            input.onchange = async () => {
                const file = input.files[0];
                const formData = new FormData();
                formData.append('image', file);

                // Get CSRF token
                const token = "{{ csrf_token() }}";

                try {
                    const response = await fetch('{{ route('admin.upload.image') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        body: formData
                    });

                    const result = await response.json();

                    if (result.success) {
                        // Get the current cursor position
                        const range = this.quill.getSelection(true);

                        // Insert the image
                        this.quill.insertEmbed(range.index, 'image', result.url);

                        // Move cursor to next position
                        this.quill.setSelection(range.index + 1);
                    } else {
                        alert('Failed to upload image');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Error uploading image');
                }
            };
        }

        const quill = new Quill('#editor-container', {
            theme: 'snow',
            modules: {
                toolbar: {
                    container: [
                        [{
                            'header': [2, 3, 4, 5, 6, false]
                        }],
                        ['bold', 'italic', 'underline'],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }],
                        ['image', 'link'],
                    ],
                    handlers: {
                        image: imageHandler
                    }
                },
                imageResize: {
                    modules: ['Resize', 'DisplaySize', 'Toolbar']
                }
            }
        });

        // submitting form
        const postForm = document.getElementById('postForm'); // Select the form
        const descriptionInput = document.getElementById('description'); // Hidden input field

        postForm.addEventListener('submit', function(e) {
            // Update the hidden input with the Quill editor's HTML content
            descriptionInput.value = quill.root.innerHTML;

            // Optional: Check if the description is empty
            if (descriptionInput.value.trim() === '<p><br></p>') {
                e.preventDefault(); // Prevent form submission
                alert('Please add some content to the description!');
            }
        });
    </script>
@endpush
