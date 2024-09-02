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
                <h3 class="page-title">Add New Company Details</h3>
            </div>
        </div>
    </div>
    <div class="container-fluid mb-4">
        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <a href="{{ route('admin.companies') }}"><button class="btn btn-primary"> <i
                            class="fe fe-16 fe-arrow-left"></i>All Companies </button></a>
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

                    <form action="{{ route('store-company') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Company Name *</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="emails">Email *</label>
                            <div id="emails-container">
                                <div class="input-group mb-2">
                                    <input type="email" class="form-control" name="emails[]" required>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary" id="add-email">Add More</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="contact_person">Contact Person:</label>
                            <div id="contact-persons-container">
                                <div class="contact-person">
                                    <div class="form-group mb-2">
                                        <input type="text" class="form-control" name="contact_person[0][name]"
                                            placeholder="Name *" required>
                                        <input type="email" class="form-control" name="contact_person[0][email]"
                                            placeholder="Email">
                                        <input type="text" class="form-control" name="contact_person[0][phone_number]"
                                            placeholder="Phone Number">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary" id="add-contact-person">Add More</button>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>


                </div>

            </div>
        </div>

    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            var emailIndex = 1;
            var contactPersonIndex = 1;

            $('#add-email').click(function() {
                var emailField = `
            <div class="input-group mb-2">
                <input type="email" class="form-control" name="emails[]" required>
                <div class="input-group-append">
                    <button type="button" class="btn btn-danger remove-email">&times;</button>
                </div>
            </div>
        `;
                $('#emails-container').append(emailField);
            });

            $('#add-contact-person').click(function() {
                var contactPersonField = `
            <div class="contact-person mt-4">
                <div class="form-group mb-2">
                    <label for="contact_person">Contact Person:</label>
                    <input type="text" class="form-control" name="contact_person[` + contactPersonIndex + `][name]" placeholder="Name *" required>
                    <input type="email" class="form-control" name="contact_person[` + contactPersonIndex + `][email]" placeholder="Email" >
                    <input type="text" class="form-control" name="contact_person[` + contactPersonIndex + `][phone_number]" placeholder="Phone Number" >
                    <div class="input-group-append justify-content-end">
                        <button type="button" class="btn btn-danger remove-contact-person">&times;</button>
                    </div>
                </div>
            </div>
        `;
                $('#contact-persons-container').append(contactPersonField);
                contactPersonIndex++;
            });

            // Remove email field
            $(document).on('click', '.remove-email', function() {
                $(this).closest('.input-group').remove();
            });

            // Remove contact person field
            $(document).on('click', '.remove-contact-person', function() {
                $(this).closest('.form-group').remove();
            });
        });
    </script>
@endpush
