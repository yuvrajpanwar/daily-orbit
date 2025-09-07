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
                <a href="{{ route('admin.authors') }}"><button class="btn btn-primary"> <i
                            class="fe fe-16 fe-arrow-left"></i>Back</button></a>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h3 class="page-title">Add New Author </h3>
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

                    <form id="authorForm" method="POST" action="{{ route('admin.store-author') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                    
                            <!-- Name -->
                            <div class="mb-3 w-100">
                                <label>Name :</label>
                                <input type="text" class="form-control w-100 @error('name') is-invalid @enderror"
                                    name="name" id="name" value="{{ old('name') }}" required maxlength="100">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                    
                            <!-- Email -->
                            <div class="mb-3 w-100">
                                <label>Email :</label>
                                <input type="email" class="form-control w-100 @error('email') is-invalid @enderror"
                                    name="email" id="email" value="{{ old('email') }}" required maxlength="100">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                    
                            <!-- Phone Number -->
                            <div class="mb-3 w-100">
                                <label>Phone Number :</label>
                                <input type="text" class="form-control w-100 @error('phone_number') is-invalid @enderror"
                                    name="phone_number" id="phone_number" value="{{ old('phone_number') }}" required maxlength="100">
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                    
                            <!-- About -->
                            <div class="mb-3 w-100">
                                <label>About :</label>
                                <textarea class="form-control w-100 @error('about') is-invalid @enderror" name="about" id="about"
                                    rows="4" maxlength="500">{{ old('about') }}</textarea>
                                @error('about')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3 w-100">
                                <label>Password :</label>
                                <input type="password" class="form-control w-100 @error('password') is-invalid @enderror" name="password" id="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Type -->
                            <div class="mb-3 w-100">
                                <label>Type :</label>
                                <select class="form-control w-100 @error('type') is-invalid @enderror" name="type" id="type" required>
                                    <option value="">Select Type</option>
                                    <option value="author" {{ old('type') == 'author' ? 'selected' : '' }}>Author</option>
                                    <option value="admin-author" {{ old('type') == 'admin-author' ? 'selected' : '' }}>Admin Author</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                    
                            <!-- Profile Picture -->
                            <div class="mb-3 w-100">
                                <label>Profile Picture (Square Only):</label>
                                <input type="file" class="form-control w-100 @error('profile_picture') is-invalid @enderror"
                                    name="profile_picture" id="profile_picture" accept="image/*">
                                @error('profile_picture')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                    
                            <!-- Cropping Section -->
                            <div class="mb-3 w-100">
                                <div id="crop-container" style="display: none;">
                                    <img id="crop-image" style="max-width: 100%; max-height: 400px; display: block;">
                                    <button type="button" id="crop-button" class="btn btn-success mt-2">Crop and Upload</button>
                                </div>
                            </div>
                    
                        </div>
                    
                        <!-- Submit Button -->
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                    </form>
                    

                </div>

            </div>
        </div>

    </div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let cropper;
        const profilePictureInput = document.getElementById('profile_picture');
        const cropContainer = document.getElementById('crop-container');
        const cropImage = document.getElementById('crop-image');
        const cropButton = document.getElementById('crop-button');

        profilePictureInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    cropImage.src = e.target.result;
                    cropContainer.style.display = 'block';

                    // Initialize Cropper.js
                    if (cropper) {
                        cropper.destroy();
                    }
                    cropper = new Cropper(cropImage, {
                        aspectRatio: 1, // Square cropping
                        viewMode: 2,
                        preview: '.img-preview'
                    });
                };
                reader.readAsDataURL(file);
            }
        });

        cropButton.addEventListener('click', function () {
            if (cropper) {
                cropper.getCroppedCanvas({
                    width: 300,
                    height: 300
                }).toBlob(function (blob) {
                    // Append cropped image to FormData
                    const formData = new FormData();
                    formData.append('cropped_image', blob, 'profile_picture.jpg');

                    // Simulate the file input
                    const fileInput = new File([blob], 'profile_picture.jpg', { type: blob.type });
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(fileInput);
                    profilePictureInput.files = dataTransfer.files;

                    alert('Image cropped and ready to upload.');
                    cropContainer.style.display = 'none';
                    cropper.destroy();
                }, 'image/jpeg');
            }
        });
    });
</script>

@endpush
 