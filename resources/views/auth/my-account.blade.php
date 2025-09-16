@extends('layouts.app')

@push('css')
    <style>
        /* Account Card Styles (same pattern as login/register) */
        .account-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top: 10px;
            margin-bottom: 10px;
            border: 1px solid #f0f0f0;
            transition: all 0.3s ease;
        }

        .account-card:hover {
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .account-header {
            background: linear-gradient(135deg, #ff4757 0%, #ff3838 100%);
            padding: 20px 12px;
            align-items: center;
            justify-content: space-between;
            text-align: center;
            color: white;
            display: flex;
        }

        .account-title {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .account-body {
            padding: 25px 5px 5px 10px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 15px 20px 15px 50px;
            border: 2px solid #e1e8ed;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
            color: #2c3e50;
        }

        .form-input:focus {
            outline: none;
            border-color: #ff4757;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(255, 71, 87, 0.1);
            transform: translateY(-1px);
        }

        .form-input.is-invalid {
            border-color: #e74c3c;
            background: #fdf2f2;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #7f8c8d;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-input:focus+.input-icon {
            color: #ff4757;
        }

        .error-message {
            display: block;
            margin-top: 8px;
            color: #e74c3c;
            font-size: 13px;
            font-weight: 500;
        }

        .update-btn {
            width: 100%;
            padding: 16px 24px;
            background: linear-gradient(135deg, #ff4757 0%, #ff3838 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }

        .update-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 71, 87, 0.3);
        }

        .delete-btn {
            background: none !important;
            color: red;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .delete-btn:hover {
            background: #c0392b;
            box-shadow: 0 10px 25px rgba(231, 76, 60, 0.3);
        }


        /* Responsive */
        @media (max-width: 768px) {
            .account-card {
                margin: 10px 20px;
                border-radius: 16px;
            }
        }

        .account-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
            margin-bottom: 50px;
            border: 1px solid #f0f0f0;
            transition: all 0.3s ease;
        }

        .info-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-label {
            font-weight: 600;
            color: #2c3e50;
            font-size: 14px;
            text-transform: uppercase;
        }

        .info-value {
            font-size: 16px;
            color: #34495e;
        }

        .action-btn {
            margin-top: 20px;
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .edit-btn {
            background: linear-gradient(135deg, #ff4757 0%, #ff3838 100%);
        }

        .edit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 71, 87, 0.3);
        }

        /* Modal Styles */
        .modal-confirm {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            width: 400px;
            max-width: 90%;
        }

        .modal-buttons {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            gap: 15px;
        }

        .cancel-btn,
        .confirm-btn {
            flex: 1;
            padding: 12px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
        }

        .cancel-btn {
            background: #bdc3c7;
            color: white;
        }

        .confirm-btn {
            background: #e74c3c;
            color: white;
        }

        .info-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            /* padding: 8px 0; */
            /* border-bottom: 1px solid #eee; */
        }

        .info-label {
            /* font-weight: bold; */
            flex: 1;
        }

        .info-value {
            flex: 2;
            text-align: right;
            color: #333;
        }

        .edit-input {
            flex: 2;
            text-align: right;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 4px 8px;
        }

        .edit-btn {
            margin-left: 10px;
            background: none;
            border: none;
            cursor: pointer;
            color: #ff4d4d;
            font-size: 18px;
        }

        .avatar-img {
            height: 70px;
            width: 70px;
            border-radius: 50%;
            cursor: pointer;
            object-fit: cover;
        }

        .avatar-dropdown {
            position: relative;
            display: inline-block;
        }

        .avatar-dropdown-menu {
            position: absolute;
            top: 80px;
            right: 0;
            background: linear-gradient(135deg, #ff4757 0%, #ff3838 100%);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 10px;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }
    </style>
@endpush

@section('main')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="account-card mb-1">
                    <div class="account-header">
                        <h3 class="account-title">{{ __('My Account') }}</h3>

                        <!-- Avatar -->
                        <div class="avatar-dropdown">
                            <img src="{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : asset('uploads/users/default-avatar.png') }}"
                                alt="Profile Picture" class="avatar-img" onclick="toggleAvatarDropdown()">

                            <!-- Dropdown -->
                            <div class="avatar-dropdown-menu" id="avatarDropdown" hidden>
                                <form id="avatarForm" method="POST" enctype="multipart/form-data"
                                    action="{{ route('account.avatar.update') }}">
                                    @csrf
                                    <label for="avatarUpload" class="btn-upload">
                                        <i class="fas fa-upload"></i> Change Image
                                    </label>
                                    <input type="file" id="avatarUpload" name="avatar" accept="image/*" hidden>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Cropper Modal -->
                    <div id="cropContainer" style="display:none; text-align:center; margin:20px;">
                        <img id="cropImage" style="max-width:100%; display:block; margin:auto;">
                        <button id="cropBtn" type="button" class="btn btn-primary mt-3"
                            style="background: linear-gradient(135deg, #ff4757 0%, #ff3838 100%)">Crop & Save</button>
                    </div>


                    <form method="POST" action="{{ route('account.update') }}" id="accountForm">
                        @csrf
                        @method('PUT')
                        <div class="account-body">
                            <!-- NAME -->
                            <div class="info-item">
                                <span class="info-label">{{ __('Name') }}</span>
                                <span class="info-value" id="name-value">{{ auth()->user()->name }}</span>
                                <input type="text" name="name" id="name-input" class="edit-input"
                                    value="{{ auth()->user()->name }}" hidden>
                                <button type="button" class="edit-btn" onclick="toggleEdit('name')"><i
                                        class="fa fa-edit"></i></button>
                            </div>
                            <!-- EMAIL -->
                            <div class="info-item">
                                <span class="info-label">{{ __('Email') }}</span>
                                <span class="info-value" id="email-value">{{ auth()->user()->email }}</span>
                                <input type="email" name="email" id="email-input" class="edit-input"
                                    value="{{ auth()->user()->email }}" hidden>
                                <button type="button" class="edit-btn" onclick="toggleEdit('email')"><i
                                        class="fa fa-edit"></i></button>
                            </div>
                            <!-- MOBILE -->
                            <div class="info-item">
                                <span class="info-label">{{ __('Mobile') }}</span>
                                <span class="info-value"
                                    id="mobile-value">{{ auth()->user()->mobile_number ?? '-' }}</span>
                                <input type="text" name="mobile_number" id="mobile-input" class="edit-input"
                                    value="{{ auth()->user()->mobile_number }}" hidden>
                                <button type="button" class="edit-btn" onclick="toggleEdit('mobile')"><i
                                        class="fa fa-edit"></i></button>
                            </div>
                            <!-- ABOUT -->
                            <div class="info-item">
                                <span class="info-label">{{ __('About') }}</span>
                                <span class="info-value"
                                    id="about-value">{{ optional(auth()->user()->detail)->about ?? '-' }}</span>
                                <textarea name="about" id="about-input" class="edit-input" hidden>{{ optional(auth()->user()->detail)->about }}</textarea>
                                <button type="button" class="edit-btn" onclick="toggleEdit('about')"><i
                                        class="fa fa-edit"></i></button>
                            </div>
                            <!-- ADDRESS -->
                            <div class="info-item">
                                <span class="info-label">{{ __('Address') }}</span>
                                <span class="info-value"
                                    id="address-value">{{ optional(auth()->user()->detail)->address ?? '-' }}</span>
                                <input type="text" name="address" id="address-input" class="edit-input"
                                    value="{{ optional(auth()->user()->detail)->address }}" hidden>
                                <button type="button" class="edit-btn" onclick="toggleEdit('address')"><i
                                        class="fa fa-edit"></i></button>
                            </div>
                            <!-- GENDER -->
                            <div class="info-item">
                                <span class="info-label">{{ __('Gender') }}</span>
                                <span class="info-value"
                                    id="gender-value">{{ ucfirst(optional(auth()->user()->detail)->gender) ?? '-' }}</span>
                                <select name="gender" id="gender-input" class="edit-input" hidden>
                                    <option value="male"
                                        {{ optional(auth()->user()->detail)->gender == 'male' ? 'selected' : '' }}>Male
                                    </option>
                                    <option value="female"
                                        {{ optional(auth()->user()->detail)->gender == 'female' ? 'selected' : '' }}>Female
                                    </option>
                                </select>
                                <button type="button" class="edit-btn" onclick="toggleEdit('gender')"><i
                                        class="fa fa-edit"></i></button>
                            </div>
                            <!-- AGE -->
                            <div class="info-item">
                                <span class="info-label">{{ __('Age') }}</span>
                                <span class="info-value"
                                    id="age-value">{{ optional(auth()->user()->detail)->age ?? '-' }}</span>
                                <input type="number" name="age" id="age-input" class="edit-input"
                                    value="{{ optional(auth()->user()->detail)->age }}" hidden>
                                <button type="button" class="edit-btn" onclick="toggleEdit('age')"><i
                                        class="fa fa-edit"></i></button>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mb-4">
                            <button type="submit" class="update-btn" style="width: 90%">
                                <span>{{ __('Update Account') }}</span>
                                <i class="fas fa-save"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <form id="deleteAccountForm" method="POST" action="{{ route('account.destroy') }}"
                    class="p-4 mb-4 text-center">
                    @csrf
                    @method('DELETE')
                    <span class="ml-2 mb-4">Want to remove all your data?</span>
                    <button type="button" class="delete-btn" onclick="openModal()">
                        <i class="fas fa-trash"></i> {{ __('Delete Account') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="modal-confirm" id="confirmModal" style="display: none;">
        <div class="modal-content">
            <h4>Are you sure?</h4>
            <p>This action cannot be undone. Your account will be permanently deleted.</p>
            <div class="modal-buttons">
                <button type="button" class="cancel-btn" onclick="closeModal()">Cancel</button>
                <button type="button" id="confirmDeleteBtn" class="confirm-btn">Yes, Delete</button>
            </div>
        </div>
    </div>
    <script>
        function openModal() {
            document.getElementById("confirmModal").style.display = "flex";
        }

        function closeModal() {
            document.getElementById("confirmModal").style.display = "none";
        }

        document.getElementById("confirmDeleteBtn").addEventListener("click", function() {
            const btn = this;
            btn.disabled = true;
            btn.textContent = "Loading...";

            // submit the form
            document.getElementById("deleteAccountForm").submit();
        });

        function toggleEdit(field) {
            let valueSpan = document.getElementById(field + "-value");
            let inputField = document.getElementById(field + "-input");

            if (inputField.hidden) {
                valueSpan.hidden = true;
                inputField.hidden = false;
                inputField.focus();
            } else {
                valueSpan.hidden = false;
                inputField.hidden = true;
            }
        }
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

    <script>
        function toggleAvatarDropdown() {
            document.getElementById("avatarDropdown").hidden = !document.getElementById("avatarDropdown").hidden;
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let cropper;
            const avatarUpload = document.getElementById("avatarUpload");
            const cropContainer = document.getElementById("cropContainer");
            const cropImage = document.getElementById("cropImage");
            const cropBtn = document.getElementById("cropBtn");

            // When user selects file
            avatarUpload.addEventListener("change", function(event) {
                //toggle avatar dropdown toggleAvatarDropdown 
                toggleAvatarDropdown();


                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        cropImage.src = e.target.result;
                        cropContainer.style.display = "block";

                        // Destroy previous cropper if exists
                        if (cropper) cropper.destroy();

                        // Init cropper
                        cropper = new Cropper(cropImage, {
                            aspectRatio: 1, // square
                            viewMode: 2,
                            preview: ".img-preview"
                        });
                    };
                    reader.readAsDataURL(file);
                }
            });

            // On crop button click
            cropBtn.addEventListener("click", function() {
                //disable this button and text to uploading...
                cropBtn.disabled = true;
                cropBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';



                if (!cropper) return;

                // Main profile picture (400x400 compressed)
                cropper.getCroppedCanvas({
                    width: 400,
                    height: 400,
                }).toBlob((blob) => {
                    let formData = new FormData();
                    formData.append("profile_picture", blob, "profile.png");

                    // Generate thumbnail (100x100)
                    cropper.getCroppedCanvas({
                        width: 100,
                        height: 100,
                    }).toBlob((thumbBlob) => {
                        formData.append("avatar", thumbBlob, "avatar.png");

                        // Send to backend
                        fetch("{{ route('account.avatar.update') }}", {
                                method: "POST",
                                body: formData,
                                headers: {
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                }
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    location.reload();
                                } else {
                                    alert("Upload failed");
                                }
                            })
                            .catch(() => alert("Something went wrong"));
                    }, "image/png", 0.8); // compress thumbnail
                }, "image/jpeg", 0.9); // compress main image
            });
        });
    </script>
    <script>
        //on submit of accountForm disable the submit button
        document.getElementById("accountForm").addEventListener("submit", function() {
            const submitButton = this.querySelector(".update-btn");
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
        });
    </script>
@endsection
