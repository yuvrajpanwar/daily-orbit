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
                <h3 class="page-title">Add New Category </h3>
            </div>
        </div>
    </div>
    <div class="container-fluid mb-4">
        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <a href="{{ route('admin.categories') }}"><button class="btn btn-primary"> <i class="fe fe-16 fe-arrow-left"></i>All Categories </button></a>
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

                    <form method="POST" action="{{route('admin.store-category')}}">
                        @csrf

                        <div class="form-row">
                            <div class="mb-3 w-100">
                                <label>Name :</label>
                                <input type="text" class="form-control w-100" name="name" id="name"
                                    value="{{ old('name') }}" required maxlength="20">
                                    <small id="name_count">0/20</small>
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

            updateCount('name', 'name_count', 20);
         

        });
    </script>
@endpush