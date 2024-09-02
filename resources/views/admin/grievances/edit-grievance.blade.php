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
                <h3 class="page-title">Edit Grievance </h3>
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

                    <p><strong>Original Description:</strong></p>
                    <p>{{ $grievance->description }}</p>
                    <p><strong>Member Name : </strong> {{ $grievance->member_name }} <strong>
                            <br>Company : </strong> {{ $grievance->company_name }} <strong>
                            <br>
                            City : </strong> {{ $grievance->city_town }} <strong> Pin : </strong> {{ $grievance->pin_code }}
                    </p>

                </div>

            </div>

            <div class="card col-md-6">

                <div class="card-body">

                    <form method="POST" action="{{ route('update-grievance', ['grievance' => $grievance->id]) }}">
                        @csrf
                        <div class="form-row">
                            <div class="mb-3 w-100">
                                <label>Title</label>
                                <input type="text" class="form-control w-100" name="title_by_admin" id="title_by_admin"
                                    value="{{ $grievance->title_by_admin }}" required maxlength="70">
                                <small id="title_count">0/70</small>

                            </div>
                        </div>

                        <div class="form-row">
                            <div class="mb-3 w-100">
                                <label class="w-100">Description</label>
                                <textarea class="w-100" name="description_by_admin" id="description_by_admin" cols="30" rows="10" required maxlength="600">{{ $grievance->description_by_admin }}</textarea>
                                <small id="description_count">0/600</small>

                            </div>
                        </div>

                        <div class="form-row">
                            <div class="mb-3 w-100">
                                <label>Company Name</label>
                                <input type="text" class="form-control w-100" name="company_name_by_admin"
                                id="company_name_by_admin"
                                    value="{{ $grievance->company_name_by_admin }}" required maxlength="50">
                                <small id="company_name_count">0/50</small>

                            </div>
                        </div>



                        <button class="btn btn-primary" type="submit"> Update </button>
                    </form>

                </div>

            </div>

        </div>

    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            function updateCount(elementId, countId, maxCount) {
                const element = document.getElementById(elementId);
                const countDisplay = document.getElementById(countId);

                const updateCountDisplay = () => {
                    const currentCount = element.value.length;
                    countDisplay.textContent = `${currentCount}/${maxCount}`;
                };

                element.addEventListener('input', updateCountDisplay);
                updateCountDisplay(); // Initialize the count display
            }

            updateCount('title_by_admin', 'title_count', 70);
            updateCount('description_by_admin', 'description_count', 600);
            updateCount('company_name_by_admin', 'company_name_count', 50);
        });
    </script>
@endpush
