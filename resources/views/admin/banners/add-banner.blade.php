@extends('admin/admin-layout/admin-app')

@push('css')
    <style type="text/css">
        .error {
            color: red;
        }

        #alert-success {
            transition-duration: 0.3s;
            /* Adjust the duration as needed */
            transition-timing-function: ease-in-out;
            /* Adjust the easing function as needed */
        }

        .close-button {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            color: #333;
            text-decoration: none;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h3 class="page-title">Add New Banner </h3>
            </div>
        </div>
    </div>
    <div class="container-fluid mb-4">
        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <a href="{{ route('admin.banners') }}"><button class="btn btn-primary"> <i
                            class="fe fe-16 fe-arrow-left"></i>All Banners </button></a>
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

            <div class="card col-md-7">

                <div class="card-body">

                    <form method="post" action="{{ route('store-banner') }}" id="add-banner" enctype="multipart/form-data">
                        @csrf

                        <div class="form-row">
                            <div class="mb-3 w-100">
                                <label>Page</label>
                                <select name="page" id="page" class="form-control" required>
                                    <option value="" selected disabled class="text-center">--------Select Page--------
                                    </option>
                                    <option value="home-page">Home Page</option>
                                    <option value="login-page">Login Page</option>
                                    <option value="register-page">Register Page</option>
                                    <option value="appreciations-page">Appreciations Page</option>
                                    <option value="grievances-page">Grievances Page</option>
                                    <option value="posts-page">Posts Page</option>
                                    <option value="advisories-page">Advisories Page</option>
                                    <option value="about-page">About Page</option>
                                    <option value="my-account-page">My Account Page</option>
                                    <option value="winners-page">Winners Page</option>

                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="mb-3 w-100">
                                <label class="w-100">Column</label>
                                <select name="column" id="column" class="form-control" required>
                                    <option value="" selected disabled class="text-center">-------Select
                                        Column-------</option>
                                    <option value="left-column">Left Column</option>
                                    <option value="right-column">Right Column</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="mb-3 w-100">
                                <label class="w-100">Banner Number</label>
                                <select name="banner_number" id="banner-number" class="form-control" required>
                                    <option value="" selected disabled class="text-center">---Select
                                        Banner Number---</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="mb-3 w-100">
                                <label class="w-100">Opens In :</label>
                                <select name="tab" class="form-control" required>
                                    <option value="same_tab" selected>Same Tab</option>
                                    <option value="new_tab">New Tab</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="mb-3 w-100">
                                <label>Link</label>
                                <input type="url" class="form-control w-100" name="href" id="link"
                                    value="" placeholder="Enter Link (https://example.com)" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="mb-3 w-50 pr-2">
                                <label>Start Date</label>
                                <input type="date" class="form-control w-100" name="start_date" id="start-date" required>
                            </div>
                            <div class="mb-3 w-50 pl-2">
                                <label>End Date</label>
                                <input type="date" class="form-control w-100" name="end_date" id="end_date">
                                <small">Don't fill End-Date to display always</small>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="mb-3 w-100">
                                <label>Image (size 630*350 ) </label>
                                <input type="file" class="form-control w-100" name="image" id="image" accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml" required>
                            </div>
                        </div>

                        <button class="btn btn-primary" type="submit"> Add </button>
                        
                    </form>

                </div>

            </div>
        </div>

    </div>
@endsection

@push('js')
    <script>
        // Get today's date
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0'); // Months are zero-based, so add 1
        const day = String(today.getDate()).padStart(2, '0');
        const todayDate = `${year}-${month}-${day}`;

        // Set the value of the date input field to today's date
        document.getElementById('start-date').value = todayDate;
    </script>
@endpush
