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
                <a href="{{ route('admin.authors') }}"><button class="btn btn-primary"> <i
                            class="fe fe-16 fe-arrow-left"></i>Back</button></a>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h3 class="page-title">Edit Author</h3>
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

                    <form id="editAuthorForm" method="POST" action="{{ route('admin.update-author', $author->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                    
                        <div class="form-row">
                    
                            <!-- Name -->
                            <div class="mb-3 w-100">
                                <label>Name :</label>
                                <input type="text" class="form-control w-100 @error('name') is-invalid @enderror"
                                    name="name" id="name" value="{{ old('name', $author->name) }}" required maxlength="100">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                    
                            <!-- Email -->
                            <div class="mb-3 w-100">
                                <label>Email :</label>
                                <input type="email" class="form-control w-100 @error('email') is-invalid @enderror"
                                    name="email" id="email" value="{{ old('email', $author->email) }}" required maxlength="100">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                    
                            <!-- Phone Number -->
                            <div class="mb-3 w-100">
                                <label>Phone Number :</label>
                                <input type="text" class="form-control w-100 @error('phone_number') is-invalid @enderror"
                                    name="phone_number" id="phone_number" value="{{ old('phone_number', $author->phone_number) }}" maxlength="20">
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                    
                            <!-- About -->
                            <div class="mb-3 w-100">
                                <label>About :</label>
                                <textarea class="form-control w-100 @error('about') is-invalid @enderror" name="about" id="about" rows="4"
                                    maxlength="500">{{ old('about', $author->about) }}</textarea>
                                @error('about')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                    
                            <!-- Profile Picture -->
                            <div class="mb-3 w-100">
                                <label>Profile Picture (Square Only):</label>
                                <input type="file" class="form-control w-100 @error('profile_picture') is-invalid @enderror"
                                    name="profile_picture" id="profile_picture_input" accept="image/*">
                                <small>Leave empty if you don't want to update the picture.</small>
                                @error('profile_picture')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                    
                                <!-- Cropper Modal -->
                                <div id="cropperModal" style="display: none;">
                                    <div class="cropper-container">
                                        <img id="cropperImage" style="max-width: 100%;" />
                                        <button type="button" id="cropImageButton" class="btn btn-success mt-2">Crop Image</button>
                                    </div>
                                </div>
                    
                                <!-- Cropped Image Preview -->
                                <div class="mt-3" id="croppedImagePreview" style="display: none;">
                                    <img id="croppedImage" src="" alt="Cropped Preview" class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                                </div>
                    
                                <!-- Current Profile Picture -->
                                @if ($author->profile_picture)
                                    <div class="mt-3">
                                        <img src="{{ asset('uploads/authors/' . $author->profile_picture) }}" alt="Profile Picture"
                                            class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                                    </div>
                                @endif
                            </div>
                    
                            <!-- Password -->
                            <div class="mb-3 w-100">
                                <label>New Password (Optional):</label>
                                <input type="password" class="form-control w-100 @error('password') is-invalid @enderror"
                                    name="password" id="password" minlength="6">
                                <small>Leave empty if you don't want to change the password.</small>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Type -->
                            <div class="mb-3 w-100">
                                <label>Type :</label>
                                <select class="form-control w-100 @error('type') is-invalid @enderror" name="type" id="type" required>
                                    <option value="">Select Type</option>
                                    <option value="author" {{ old('type', $author->type) == 'author' ? 'selected' : '' }}>Author</option>
                                    <option value="admin-author" {{ old('type', $author->type) == 'admin-author' ? 'selected' : '' }}>Admin Author</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                    
                        </div>
                    
                        <!-- Submit Button -->
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit">Update Author</button>
                        </div>
                    </form>
                    
                    

                </div>

            </div>
        @endsection

        @push('js')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

        <script>
            document.getElementById("profile_picture_input").addEventListener("change", function (event) {
                const modal = document.getElementById("cropperModal");
                const cropperImage = document.getElementById("cropperImage");
                const file = event.target.files[0];
        
                if (file) {
                    const reader = new FileReader();
        
                    reader.onload = function (e) {
                        cropperImage.src = e.target.result;
                        modal.style.display = "block";
        
                        // Initialize Cropper.js
                        const cropper = new Cropper(cropperImage, {
                            aspectRatio: 1,
                            viewMode: 2,
                        });
        
                        // Handle crop button
                        document.getElementById("cropImageButton").onclick = function () {
                            const canvas = cropper.getCroppedCanvas();
                            const croppedImage = document.getElementById("croppedImage");
                            croppedImage.src = canvas.toDataURL("image/jpeg");
                            croppedImage.style.display = "block";
        
                            // Add cropped image to a hidden input field
                            canvas.toBlob((blob) => {
                                const croppedFile = new File([blob], file.name, {
                                    type: file.type,
                                });
                                const dataTransfer = new DataTransfer();
                                dataTransfer.items.add(croppedFile);
                                document.getElementById("profile_picture_input").files = dataTransfer.files;
                            });
        
                            modal.style.display = "none";
                        };
                    };
        
                    reader.readAsDataURL(file);
                }
            });
        </script>
        
        @endpush
