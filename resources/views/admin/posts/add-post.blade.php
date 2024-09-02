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
                <h3 class="page-title">Add New Post </h3>
            </div>
        </div>
    </div>
    <div class="container-fluid mb-4">
        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <a href="{{ route('admin.posts') }}"><button class="btn btn-primary"> <i
                            class="fe fe-16 fe-arrow-left"></i>All Posts </button></a>
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
            @if (isset($data))
                <div  class="card col-md-6">
                    <div>
                        <div>
                            <div class="modal-header">
                                <h5 class="modal-title">Details of {{$type}}</h5>
                            </div>
                            <div class="modal-body">
                                <p><strong>Description:</strong></p>
                                <p id="modalAppreciationDescription">{{ $data->description }}</p>
                                <p><strong>Member Name : </strong> <span
                                        id="modalAppreciationMemberName">{{ $data->member_name }}</span> <strong> Company :
                                    </strong> <span id="modalAppreciationCompany">{{ $data->company_name }}</span><strong>
                                        <br>
                                        City : </strong> <span id="modalAppreciationCity">{{ $data->city_town }}</span>
                                    <strong> Pin : </strong> <span id="modalAppreciationPin">{{ $data->pin_code }}</span>
                                </p>
                                <hr>
                                <p><strong>Title By Admin : </strong></p>
                                <p id="modalTitleByAdmin">{{ $data->title_by_admin }}</p>
                                <p><strong>Description By Admin : </strong></p>
                                <p id="modalDescriptionByAdmin">{{ $data->description_by_admin }}</p>
                                <p><strong>Company Name By Admin : </strong>
                                    <span id="modalCompanyNameByAdmin">{{ $data->company_name_by_admin }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif


            <div class="card col-md-6">

                <div class="card-body">

                    <form method="POST" action="{{ route('store-post') }}" id="add-post">
                        @csrf

                        <div class="form-row">
                            <div class="mb-3 w-100">
                                <label>Title</label>
                                <input type="text" class="form-control w-100" name="post_title" id="post_title"
                                    value="{{ old('post_title') }}" required maxlength="70">
                                <small id="title_count">0/70</small>

                            </div>
                        </div>

                        <div class="form-row">
                            <div class="mb-3 w-100">
                                <label class="w-100">Description</label>
                                <textarea class="w-100" name="post_description" id="post_description" cols="30" rows="10" required
                                    maxlength="500"></textarea>
                                <small id="description_count">0/500</small>

                            </div>
                        </div>

                        <div class="form-row">
                            <div class="mb-3 w-100">
                                <label>Company</label>
                                <input type="text" class="form-control w-100" name="company" id="company"
                                    value="{{ old('company') }}" required maxlength="50">
                                <small id="company_count">0/50</small>

                            </div>
                        </div>

                        <div class="form-row">
                            <div class="mb-3 w-100">
                                <label>Author</label>
                                <input type="text" class="form-control w-100" name="author" id="author"
                                    value="{{ old('Author') }}" required maxlength="20">
                                <small id="author_count">0/20</small>

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

            updateCount('post_title', 'title_count', 70);
            updateCount('post_description', 'description_count', 500);
            updateCount('company', 'company_count', 50);
            updateCount('author', 'author_count', 20);

        });
    </script>
@endpush
