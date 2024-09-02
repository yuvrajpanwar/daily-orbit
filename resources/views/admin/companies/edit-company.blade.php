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
                <h3 class="page-title">Edit Company Details</h3>
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

                    <form action="{{ route('update-company', $company->id) }}" method="POST">
                        @csrf
                        <div id="emailsContainer">
                            <div class="form-group">
                                <label for="name">Company Name*</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $company->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="emails">Email*</label>
                                @foreach (json_decode($company->emails) as $key => $email)
                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control" name="emails[]"
                                            value="{{ $email }}" required>

                                        @if ($key != 0)
                                            <div class="form-group-append d-flex justify-content-end">
                                                <button class="btn btn-danger remove-email" type="button">Remove</button>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary" id="addEmail">Add More</button>
                        </div>
                        <div id="contactPersonsContainer">
                            <div class="form-group">
                                @foreach (json_decode($company->contact_person) as $key => $person)
                                    <div class="contact-person-group">
                                        <div class="form-group mb-3">
                                            <label for="contact_person">Contact Person:</label>

                                            <input type="text" class="form-control" name="contact_persons[{{$key}}][name]"
                                                value="{{ $person->name }}" placeholder="Name*" required>
                                            <input type="email" class="form-control" name="contact_persons[{{$key}}][email]"
                                                value="{{ $person->email }}" placeholder="Email">
                                            <input type="text" class="form-control"
                                                name="contact_persons[{{$key}}][phone_number]" value="{{ $person->phone_number }}"
                                                placeholder="Phone Number">
                                            @if ($key != 0)
                                                <div class="form-group-append d-flex justify-content-end">
                                                    <button class="btn btn-danger remove-contact-person"
                                                        type="button">Remove</button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary" id="addContactPerson">Add More</button>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>

                </div>

            </div>
        </div>

    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            var emailIndex = {{ count(json_decode($company->emails)) }};
            var contactPersonIndex = {{ count(json_decode($company->contact_person)) }};

            $('#addEmail').click(function() {
                var emailField = `
                    <div class="form-group mb-2">
                        <input type="email" class="form-control" name="emails[]" placeholder="Email*" required>
                        <div class="form-group-append d-flex justify-content-end">
                            <button type="button" class="btn btn-danger remove-email">Remove</button>
                        </div>
                    </div>
                `;
                $('#emailsContainer').append(emailField);
            });

            $('#addContactPerson').click(function() {
                var contactPersonField = `
                    <div class="contact-person-group mt-4">
                        <div class="form-group mb-2">
                            <label for="contact_person">Contact Person:</label>
                            <input type="text" class="form-control" name="contact_persons[` + contactPersonIndex + `][name]" placeholder="Name *" required>
                            <input type="email" class="form-control" name="contact_persons[` + contactPersonIndex + `][email]" placeholder="Email" >
                            <input type="text" class="form-control" name="contact_persons[` + contactPersonIndex + `][phone_number]" placeholder="Phone Number" >
                            <div class="form-group-append d-flex justify-content-end">
                                <button type="button" class="btn btn-danger remove-contact-person">Remove</button>
                            </div>
                        </div>
                    </div>
                `;
                $('#contactPersonsContainer').append(contactPersonField);
                contactPersonIndex++;
            });

            // Remove email field
            $(document).on('click', '.remove-email', function() {
                $(this).closest('.form-group').remove();
            });

            // Remove contact person field
            $(document).on('click', '.remove-contact-person', function() {
                $(this).closest('.contact-person-group').remove();
            });
        });
    </script>
@endpush
