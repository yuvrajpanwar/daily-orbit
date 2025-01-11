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

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h3 class="page-title">Add New Post </h3>
            </div>
        </div>
    </div>
    <div class="container-fluid mb-4">
        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <a href="{{ route('admin.categories') }}"><button class="btn btn-primary"> <i
                            class="fe fe-16 fe-arrow-left"></i>All Categories </button></a>
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

                    <form method="POST" action="{{ route('admin.store-post') }}" enctype="multipart/form-data">
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

                            <!-- Author -->
                            <div class="mb-3 w-100">
                                <label>Author :</label>
                                <input type="text" class="form-control w-100 @error('author') is-invalid @enderror"
                                    name="author" id="author" value="{{ old('author') }}" required maxlength="100">
                                @error('author')
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

                            <!-- Description -->
                            <div class="mb-3 w-100">
                                <label>Description :</label>
                                <!-- Hidden textarea to store Quill content -->
                                <input type="hidden" name="description" id="description">
                                <!-- Quill editor container -->
                                <div id="editor-container" style="height: 800px;"
                                    class="form-control @error('description') is-invalid @enderror">
                                    {!! old('description') !!}
                                </div>
                                @error('description')
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
        const quill = new Quill('#editor-container', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{
                        'header': [ 2, 3, 4, 5, 6, false]
                    }], // Toggle header sizes
                    ['bold', 'italic', 'underline'], // Text styling
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }], // Ordered and bullet lists
                    ['image', 'link'], // Add images and links
                    [{
                        'align': []
                    }], // Add alignment options
                ],
                imageResize: {
                    modules: ['Resize', 'DisplaySize', 'Toolbar']
                }
            }
        });

        // When form is submitted, copy Quill content to hidden input
        document.querySelector('form').addEventListener('submit', function(e) {
            // Get Quill content
            const description = document.querySelector('#description');
            description.value = quill.root.innerHTML;
        });

        // If there are validation errors, restore old content
        @if (old('description'))
            quill.root.innerHTML = {!! json_encode(old('description')) !!};
        @endif
    </script>
@endpush
