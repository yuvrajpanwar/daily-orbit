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
                <h3 class="page-title">Edit Advisory </h3>
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

                    <form method="POST" action="{{ route('update-advisory', ['advisory' => $advisory->id]) }}">
                        @csrf
                        <div class="form-row">
                            <div class="mb-3 w-100">
                                <label>Title</label>
                                <input type="text" class="form-control w-100" name="advisory_title" id="advisory_title"
                                    value="{{$advisory->advisory_title}}" required maxlength="70">
                                    <small id="title_count">0/70</small>


                            </div>
                        </div>

                        <div class="form-row">
                            <div class="mb-3 w-100">
                                <label class="w-100">Description</label>
                                <textarea class="w-100" name="advisory_description" id="advisory_description" cols="30" rows="10" required maxlength="500">{{$advisory->advisory_description}}</textarea>
                                <small id="description_count">0/500</small>

                            </div>
                        </div>

                        <div class="form-row">
                            <div class="mb-3 w-100">
                                <label>Company</label>
                                <input type="text" class="form-control w-100" name="company"  id="company"
                                    value="{{$advisory->company}}" required maxlength="50">
                                    <small id="company_count">0/50</small>

                            </div>
                        </div>

                        <div class="form-row">
                            <div class="mb-3 w-100">
                                <label>Author</label>
                                <input type="text" class="form-control w-100" name="author" id="author"
                                    value="{{$advisory->author}}" required maxlength="20">
                                    <small id="author_count">0/20</small>

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

            updateCount('advisory_title', 'title_count', 70);
            updateCount('advisory_description', 'description_count', 500);
            updateCount('company', 'company_count', 50);
            updateCount('author', 'author_count', 20);

        });
    </script>
@endpush
