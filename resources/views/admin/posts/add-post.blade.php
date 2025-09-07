@extends('admin/admin-layout/admin-app')
@push('css')
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">

    <style>
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

        /* Cropper.js related styles */
        .img-container {
            margin-bottom: 1rem;
            max-height: 400px;
            width: 100%;
        }

        .img-container img {
            max-width: 100%;
            max-height: 400px;
        }

        .preview {
            overflow: hidden;
            width: 160px;
            height: 90px;
            margin: 10px;
            border: 1px solid #ddd;
            display: none;
        }

        .cropper-container {
            margin-bottom: 20px;
        }

        #thumbnail-preview-container {
            display: none;
            margin-top: 10px;
        }

        .cropper-buttons {
            margin-top: 10px;
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
            <div class="card col-md-8">
                <div class="card-body">
                    <form id="postForm" method="POST" action="{{ route('admin.store-post') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <!-- Category -->
                            <div class="mb-3 w-100">
                                <label>Category :</label>
                                <select name="category_id" id="category_id"
                                    class="form-control @error('category_id') is-invalid @enderror" required>
                                    <option value="" disabled selected class="text-center">--------Select
                                        Category--------
                                    </option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                    {!! old('description') ?? '<br><br>' !!}
                                </div>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Time -->
                            <div class="mb-3 w-100">
                                <label>Time :</label>
                                <input type="datetime-local" class="form-control w-100 @error('time') is-invalid @enderror"
                                    name="time" id="time" value="{{ old('time', date('Y-m-d\TH:i')) }}" required>
                                @error('time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Thumbnail -->
                            <div class="mb-3 w-100">
                                <label>Thumbnail Image :</label>
                                <small class="text-muted d-block mb-2">Please select an image and crop it to 16:9 ratio
                                    before submitting.</small>

                                <div class="@error('thumbnail') is-invalid @enderror">
                                    <input type="file" name="thumbnail" id="thumbnail-input" class="form-control"
                                        accept="image/*" required>

                                    <!-- Cropper.js container -->
                                    <div id="thumbnail-preview-container" class="mt-3" style="display: none;">
                                        <div class="img-container" style="max-height: 400px; overflow: hidden;">
                                            <img id="thumbnail-image" src="" alt="Thumbnail Preview"
                                                style="max-width: 100%; display: block;">
                                        </div>

                                        <!-- Preview container -->
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <h6>Preview (16:9 ratio):</h6>
                                                <div class="preview"
                                                    style="width: 200px; height: 112.5px; border: 1px solid #ddd; overflow: hidden; margin: 10px 0;">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Cropper buttons -->
                                        <div class="cropper-buttons mt-3">
                                            <button type="button" class="btn btn-primary" id="crop-btn">
                                                <i class="fe fe-crop"></i> Crop & Save
                                            </button>
                                            <button type="button" class="btn btn-secondary" id="cancel-btn">
                                                <i class="fe fe-x"></i> Cancel
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Reset button container (shows after cropping) -->
                                    <div id="reset-container" class="mt-2" style="display: none;">
                                        <button type="button" class="btn btn-outline-secondary btn-sm" id="reset-btn">
                                            <i class="fe fe-refresh-cw"></i> Change Image
                                        </button>
                                    </div>
                                </div>

                                @error('thumbnail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Hidden input to hold cropped blob (for fallback) -->
                            <input type="hidden" name="cropped_thumbnail" id="cropped_thumbnail">

                            
                            <!-- Submit Button -->
                            <div class="my-3">
                                <input class="btn btn-primary" type="submit" value="Add Post" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Cropper.js Modal -->
    <div class="modal fade" id="cropperModal" tabindex="-1" role="dialog" aria-labelledby="cropperModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cropperModalLabel">Crop Thumbnail Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <img id="modal-image" src="" alt="Thumbnail to Crop">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="modal-crop-btn">Crop & Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill-image-resize-module@3.0.0/image-resize.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script>
        // Quill Editor Configuration
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

        // Override the default image handler to prevent base64 insertion
        quill.clipboard.addMatcher('img', function(node, delta) {
            // If the image has a data URL (base64), we need to handle it
            if (node.src && node.src.startsWith('data:')) {
                // Remove the image from the delta to prevent base64 insertion
                return delta.compose(new Delta().retain(delta.length()));
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

        // Cropper.js Implementation
        document.addEventListener('DOMContentLoaded', function() {
            const thumbnailInput = document.getElementById('thumbnail-input');
            const thumbnailImage = document.getElementById('thumbnail-image');
            const thumbnailPreviewContainer = document.getElementById('thumbnail-preview-container');
            const croppedThumbnailInput = document.getElementById('cropped_thumbnail');
            const cropBtn = document.getElementById('crop-btn');
            const cancelBtn = document.getElementById('cancel-btn');
            const resetBtn = document.getElementById('reset-btn');
            const resetContainer = document.getElementById('reset-container');

            let cropper;
            let croppedBlob = null;
            let originalFileName = '';

            // When a file is selected
            thumbnailInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;

                originalFileName = file.name;
                const reader = new FileReader();

                reader.onload = function(e) {
                    // Display the thumbnail preview
                    thumbnailImage.src = e.target.result;
                    thumbnailPreviewContainer.style.display = 'block';

                    // Reset any previous states
                    resetBtn.style.display = 'none';
                    document.querySelector('.cropper-buttons').style.display = 'block';
                    thumbnailImage.style.border = '';

                    // Remove any previous success indicators
                    const existingSuccess = thumbnailPreviewContainer.querySelector('.alert-success');
                    if (existingSuccess) {
                        existingSuccess.remove();
                    }

                    // Initialize Cropper
                    if (cropper) {
                        cropper.destroy();
                    }

                    cropper = new Cropper(thumbnailImage, {
                        aspectRatio: 16 / 9,
                        viewMode: 1,
                        preview: '.preview',
                        autoCropArea: 1,
                        responsive: true,
                        zoomable: true,
                        scalable: true,
                        rotatable: true,
                        minCanvasWidth: 320,
                        minCanvasHeight: 180
                    });
                };

                reader.readAsDataURL(file);
            });

            // When crop button is clicked
            cropBtn.addEventListener('click', function() {
                if (!cropper) return;

                // Get the cropped canvas with high quality
                const canvas = cropper.getCroppedCanvas({
                    width: 1600, // Higher resolution for better quality
                    height: 900,
                    minWidth: 800,
                    minHeight: 450,
                    maxWidth: 1600,
                    maxHeight: 900,
                    fillColor: '#fff',
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high'
                });

                // Convert canvas to blob
                canvas.toBlob(function(blob) {
                    if (!blob) {
                        alert('Error cropping image. Please try again.');
                        return;
                    }

                    croppedBlob = blob;

                    // Convert blob to base64 for preview and hidden input
                    const reader = new FileReader();
                    reader.readAsDataURL(blob);

                    reader.onloadend = function() {
                        const base64data = reader.result;

                        // Set the cropped image data to the hidden input
                        croppedThumbnailInput.value = base64data;

                        // Update the preview
                        thumbnailImage.src = base64data;

                        // Destroy the cropper
                        cropper.destroy();
                        cropper = null;

                        // Hide the cropper buttons
                        document.querySelector('.cropper-buttons').style.display = 'none';

                        // Add visual indication that cropping is complete
                        thumbnailImage.style.border = '3px solid #28a745';
                        thumbnailImage.style.borderRadius = '5px';

                        // Add success indicator
                        const successIndicator = document.createElement('div');
                        successIndicator.className = 'alert alert-success mt-2';
                        successIndicator.style.padding = '8px 12px';
                        successIndicator.innerHTML =
                            '<small><i class="fe fe-check"></i> Image cropped successfully (16:9 ratio)</small>';
                        thumbnailPreviewContainer.appendChild(successIndicator);

                        // Show the reset button
                        resetContainer.style.display = 'block';
                    };
                }, 'image/jpeg', 0.92); // High quality JPEG
            });

            // When cancel button is clicked
            cancelBtn.addEventListener('click', function() {
                resetCropper();
            });

            // Reset button functionality
            resetBtn.addEventListener('click', function() {
                resetCropper();
                // Clear the file input and trigger new selection
                thumbnailInput.value = '';
                thumbnailInput.click();
            });

            // Helper function to reset cropper state
            function resetCropper() {
                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }

                thumbnailPreviewContainer.style.display = 'none';
                croppedThumbnailInput.value = '';
                croppedBlob = null;
                resetContainer.style.display = 'none';
                thumbnailImage.style.border = '';
                thumbnailImage.style.borderRadius = '';

                // Remove success indicators
                const successIndicator = thumbnailPreviewContainer.querySelector('.alert-success');
                if (successIndicator) {
                    successIndicator.remove();
                }
            }

            // Form submission handling
            const postForm = document.getElementById('postForm');
            const descriptionInput = document.getElementById('description');

            postForm.addEventListener('submit', function(e) {
                // Update the hidden input with the Quill editor's HTML content
                descriptionInput.value = quill.root.innerHTML;

                // Check if description is empty
                if (descriptionInput.value.trim() === '<p><br></p>' || descriptionInput.value.trim() ===
                    '') {
                    e.preventDefault();
                    alert('Please add some content to the description!');
                    return false;
                }

                // Check if thumbnail file is selected
                if (!thumbnailInput.files[0] && !croppedBlob) {
                    e.preventDefault();
                    alert('Please select a thumbnail image.');
                    return false;
                }

                // Ensure the thumbnail is cropped before submitting
                if (thumbnailInput.files[0] && !croppedBlob) {
                    e.preventDefault();
                    alert('Please crop the thumbnail image before submitting.');
                    return false;
                }

                // If we have a cropped blob, create a new file and replace the input
                if (croppedBlob) {
                    try {
                        // Create a new file from the cropped blob
                        const fileExtension = originalFileName.split('.').pop() || 'jpg';
                        const fileName = `cropped_thumbnail_${Date.now()}.${fileExtension}`;
                        const croppedFile = new File([croppedBlob], fileName, {
                            type: 'image/jpeg',
                            lastModified: Date.now()
                        });

                        // Create a new DataTransfer object and add the cropped file
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(croppedFile);

                        // Replace the input's files with the cropped file
                        thumbnailInput.files = dataTransfer.files;

                        console.log('Cropped file prepared for upload:', {
                            name: croppedFile.name,
                            size: croppedFile.size,
                            type: croppedFile.type
                        });

                    } catch (error) {
                        console.error('Error preparing cropped file:', error);
                        e.preventDefault();
                        alert('Error preparing the cropped image. Please try cropping again.');
                        return false;
                    }
                }

                // Additional validation can be added here
                console.log('Form submission proceeding with cropped thumbnail');
            });
        });
    </script>
@endpush
