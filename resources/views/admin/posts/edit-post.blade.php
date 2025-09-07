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

    <style>
        .img-container {
            max-height: 400px;
            overflow: hidden;
        }

        .preview {
            overflow: hidden;
            border: 1px solid #ddd;
            background: #f8f9fa;
            display: none;
        }

        .cropper-buttons {
            text-align: center;
            padding: 10px 0;
        }

        #thumbnail-image {
            max-width: 100%;
            height: auto;
        }

        .current-thumbnail-container {
            display: inline-block;
            text-align: center;
        }

        .current-thumbnail-container img {
            border: 2px solid #dee2e6;
            border-radius: 5px;
        }

        .alert-success {
            border-radius: 5px;
        }

        /* Cropper.js modal overlay fix */
        .cropper-modal {
            background-color: rgba(0, 0, 0, 0.5);
        }

        /* Ensure cropper container has proper positioning */
        #thumbnail-preview-container .img-container {
            position: relative;
        }

        /* Style the cropper buttons */
        .cropper-buttons .btn {
            margin: 0 5px;
        }

        /* Success indicator styling */
        .alert-success small {
            font-weight: 500;
        }

        /* Reset button styling */
        #reset-container {
            text-align: center;
        }
    </style>
    <!-- Add these to your HTML head section -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
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

                    <form id="editPostForm" method="POST" action="{{ route('admin.update-post', $post->id) }}"
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
                                    name="time" id="time"
                                    value="{{ old('time', $post->time ? $post->time->format('Y-m-d\TH:i') : date('Y-m-d\TH:i')) }}"
                                    required>
                                @error('time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Thumbnail -->
                            <div class="mb-3 w-100">
                                <label>Thumbnail Image :</label>
                                <small class="text-muted d-block mb-2">Leave empty if you don't want to update the
                                    thumbnail. If you select a new image, please crop it to 16:9 ratio.</small>

                                <div class="@error('thumbnail') is-invalid @enderror">
                                    <input type="file" name="thumbnail" id="thumbnail-input" class="form-control"
                                        accept="image/*">

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

                                <!-- Current Thumbnail -->
                                @if ($post->thumbnail)
                                    <div class="mt-3" id="current-thumbnail">
                                        <label class="text-muted">Current Thumbnail:</label>
                                        <div class="current-thumbnail-container">
                                            <img src="{{ $post->thumbnail_url }}" alt="Current Thumbnail"
                                                class="img-thumbnail"
                                                style="width: 200px; height: 112.5px; object-fit: cover;">
                                            <small class="d-block text-muted mt-1">Current thumbnail (16:9 ratio)</small>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Hidden input to hold cropped blob -->
                        <input type="hidden" name="cropped_thumbnail" id="cropped_thumbnail">

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
        // Edit Post - Quill Editor Configuration
        function editImageHandler() {
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

        const editQuill = new Quill('#editor-container', {
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
                        image: editImageHandler
                    }
                },
                imageResize: {
                    modules: ['Resize', 'DisplaySize', 'Toolbar']
                }
            }
        });

        // Override the default image handler to prevent base64 insertion
        editQuill.clipboard.addMatcher('img', function(node, delta) {
            // If the image has a data URL (base64), we need to handle it
            if (node.src && node.src.startsWith('data:')) {
                // Remove the image from the delta to prevent base64 insertion
                return delta.compose(new Delta().retain(delta.length()));
            }
            return delta;
        });

        // Prevent base64 images from being pasted
        editQuill.on('paste', function(e) {
            // Check if the pasted content contains base64 images
            const html = e.clipboardData.getData('text/html');
            if (html && html.includes('data:image/')) {
                e.preventDefault();
                alert('Please use the image button to upload images instead of pasting them.');
                return false;
            }
        });

        // Edit Post - Cropper.js Implementation
        document.addEventListener('DOMContentLoaded', function() {
            const thumbnailInput = document.getElementById('thumbnail-input');
            const thumbnailImage = document.getElementById('thumbnail-image');
            const thumbnailPreviewContainer = document.getElementById('thumbnail-preview-container');
            const croppedThumbnailInput = document.getElementById('cropped_thumbnail');
            const cropBtn = document.getElementById('crop-btn');
            const cancelBtn = document.getElementById('cancel-btn');
            const resetBtn = document.getElementById('reset-btn');
            const resetContainer = document.getElementById('reset-container');
            const currentThumbnail = document.getElementById('current-thumbnail');

            let cropper;
            let croppedBlob = null; // Store the cropped blob here
            let originalFileName = '';
            let hasNewImage = false;

            // Check if all required elements exist
            if (!thumbnailInput || !thumbnailImage || !thumbnailPreviewContainer) {
                console.error('Required cropper elements not found');
                return;
            }

            // When a file is selected
            thumbnailInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) {
                    // If no file selected, show current thumbnail again if it was hidden
                    if (currentThumbnail && currentThumbnail.style.display === 'none') {
                        currentThumbnail.style.display = 'block';
                    }
                    return;
                }

                hasNewImage = true;
                originalFileName = file.name;
                const reader = new FileReader();

                reader.onload = function(e) {
                    // Display the thumbnail preview
                    thumbnailImage.src = e.target.result;
                    thumbnailPreviewContainer.style.display = 'block';

                    // Hide current thumbnail when new image is selected
                    if (currentThumbnail) {
                        currentThumbnail.style.display = 'none';
                    }

                    // Reset any previous states
                    resetContainer.style.display = 'none';
                    document.querySelector('.cropper-buttons').style.display = 'block';
                    thumbnailImage.style.border = '';
                    thumbnailImage.style.borderRadius = '';

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

                    croppedBlob = blob; // Store the cropped blob

                    // Convert blob to base64 for preview and hidden input
                    const reader = new FileReader();
                    reader.readAsDataURL(blob);

                    reader.onloadend = function() {
                        const base64data = reader.result;

                        // Set the cropped image data to the hidden input (optional, for preview)
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
                            '<small><i class="fe fe-check"></i> New thumbnail cropped successfully (16:9 ratio)</small>';
                        thumbnailPreviewContainer.appendChild(successIndicator);

                        // Show the reset button
                        resetContainer.style.display = 'block';
                    };
                }, 'image/jpeg', 0.92); // High quality JPEG
            });

            // When cancel button is clicked
            cancelBtn.addEventListener('click', function() {
                resetCropper();
                // Show current thumbnail again if it exists
                if (currentThumbnail) {
                    currentThumbnail.style.display = 'block';
                }
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
                hasNewImage = false;

                // Remove success indicators
                const successIndicator = thumbnailPreviewContainer.querySelector('.alert-success');
                if (successIndicator) {
                    successIndicator.remove();
                }

                // Clear file input
                thumbnailInput.value = '';
            }

            // Form submission handling
            const editPostForm = document.getElementById('editPostForm');
            const descriptionInput = document.getElementById('description');

            editPostForm.addEventListener('submit', function(e) {
                // Update the hidden input with the Quill editor's HTML content
                descriptionInput.value = editQuill.root.innerHTML;

                // Check if description is empty
                if (descriptionInput.value.trim() === '<p><br></p>' || descriptionInput.value.trim() ===
                    '') {
                    e.preventDefault();
                    alert('Please add some content to the description!');
                    return false;
                }

                // If a new image was selected, ensure it's cropped
                if (hasNewImage && thumbnailInput.files[0] && !croppedBlob) {
                    e.preventDefault();
                    alert(
                        'Please crop the new thumbnail image before submitting, or cancel to keep the current thumbnail.');
                    return false;
                }

                // If we have a cropped blob, create a new file and replace the input
                if (croppedBlob) {
                    try {
                        // Create a new file from the cropped blob
                        const fileExtension = originalFileName.split('.').pop() || 'jpg';
                        const fileName = `cropped_thumbnail_edit_${Date.now()}.${fileExtension}`;
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

                // Log the submission status
                console.log('Edit form submission proceeding', {
                    hasNewImage: hasNewImage,
                    hasCroppedBlob: !!croppedBlob,
                    filesLength: thumbnailInput.files.length
                });
            });
        });
    </script>
@endpush
