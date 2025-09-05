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

@section('content')<div class="container-fluid mb-4">
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
                <h3 class="page-title">Edit Post</h3>
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

            <div class="card col-md-8">

                <div class="card-body">

                    <form id="postForm" method="POST" action="{{ route('admin.update-post', $post->id) }}"
                        enctype="multipart/form-data">
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
                                        <option value="{{ $category->id }}"
                                            {{ $post->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
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
                                    name="title" id="title" value="{{ old('title', $post->title) }}" required
                                    maxlength="100">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-3 w-100">
                                <label>Description :</label><br>
                                <small>(Tip : Start with an image of 9:16 ratio)</small>
                                <input type="hidden" name="description" id="description">
                                <div id="editor-container" style="height: 500px;"
                                    class="form-control @error('description') is-invalid @enderror">
                                    {!! old('description') ?? $post->description !!}
                                </div>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                           <!-- Time -->
                            <div class="mb-3 w-100">
                                <label>Time :</label>
                                <input type="datetime-local" class="form-control w-100 @error('time') is-invalid @enderror"
                                    name="time" id="time" value="{{ old('time', $post->time ? $post->time->format('Y-m-d\TH:i') : date('Y-m-d\TH:i')) }}" required>
                                @error('time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Thumbnail -->
                            <div class="mb-3 w-100">
                                <label>Thumbnail Image :</label>
                                <input type="file" name="thumbnail" id="thumbnail" class="form-control" accept="image/*">
                                <small>Leave empty if you don't want to update the thumbnail.</small>
                                @error('thumbnail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                
                                <!-- Current Thumbnail -->
                                @if ($post->thumbnail)
                                    <div class="mt-3">
                                        <img src="{{ $post->thumbnail_url }}" alt="Current Thumbnail"
                                            class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                                    </div>
                                @endif
                            </div>

                        </div>

                        <!-- Submit Button -->
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit">Update Post</button>
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
                toolbar: {
                    container: [
                        [{
                            'header': [2, 3, 4, 5, 6, false]
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
                    handlers: {
                        image: imageHandler
                    }
                },
                imageResize: {
                    modules: ['Resize', 'DisplaySize', 'Toolbar']
                }
            }
        });

        // Image upload handler function
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
                        const range = quill.getSelection(true);

                        // Insert the image URL instead of base64
                        quill.insertEmbed(range.index, 'image', result.url);

                        // Move cursor to next position
                        quill.setSelection(range.index + 1);
                    } else {
                        alert('Failed to upload image');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Error uploading image');
                }
            };
        }

        // Override the default image handler to prevent base64 insertion
        quill.clipboard.addMatcher('img', function(node, delta) {
            // If the image has a data URL (base64), we need to handle it
            if (node.src && node.src.startsWith('data:')) {
                // Remove the image from the delta to prevent base64 insertion
                return delta.compose(new Delta().retain(delta.length()));
            }
            return delta;
        });

        // Alternative approach: Listen for paste events to prevent base64 images
        quill.clipboard.addMatcher(Node.ELEMENT_NODE, function(node, delta) {
            if (node.tagName === 'IMG' && node.src && node.src.startsWith('data:')) {
                // Remove base64 images from pasted content
                return new Delta();
            }
            return delta;
        });

        // Prevent base64 images from being pasted
        quill.on('paste', function(e) {
            // Check if the pasted content contains base64 images
            const html = e.clipboardData.getData('text/html');
            if (html && html.includes('data:image/')) {
                e.preventDefault();
                alert('Please use the image button to upload images instead of pasting them.');
                return false;
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
