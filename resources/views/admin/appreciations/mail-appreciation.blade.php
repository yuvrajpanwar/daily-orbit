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

        textarea {
            white-space: pre-wrap;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h3 class="page-title">Mail Appreciation To Company</h3>
            </div>
        </div>
    </div>

    <div class="container-fluid mb-4">

        @if (session('success'))
            <div class="alert alert-success show row" id="alert-success">
                <a data-toggle="collapse" href="#alert-success" role="button" aria-expanded="true"
                    aria-controls="alert-success" class="btn-link close-button">X</a>
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger row">
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
                    <p>{{ $appreciation->description }}</p>
                    <p><strong>Member Name : </strong> {{ $appreciation->member_name }} <strong>
                            <br>Company : </strong> {{ $appreciation->company_name }} <strong>
                            <br>
                            City : </strong> {{ $appreciation->city_town }} <strong> Pin : </strong>
                        {{ $appreciation->pin_code }}
                    </p>

                </div>

            </div>

            <div class="card col-md-6">

                <div class="card-body">

                    <form method="POST" action="{{ route('mail-to-company') }}" name="mail-form" id="mail-form">
                        @csrf
                        <div class="form-row">
                            <div class="mb-3 w-100">
                                <label>Select Company:</label>
                                <select name="company" id="company-select" class="form-control w-100" required>
                                    <option value="">Select a company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="mb-3 w-100">
                                <label>Select Email Address:</label>
                                <select name="company-emails" id="company-emails-select" class="form-control w-100"
                                    required>
                                    <option value="">Select an email</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="mb-3 w-100">
                                <label>To:</label>
                                <input type="email" class="form-control w-100" name="reciver_email" id="reciver_email"
                                    value="" required placeholder="Reciver's Email" readonly required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="mb-3 w-100">
                                <label>Subject:</label>
                                <input type="text" class="form-control w-100" name="subject" id="subject"
                                    value="" required placeholder="Enter Subject" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="mb-3 w-100">
                                <label class="w-100">Message:</label>
                                <textarea class="w-100" id="message" name="message" rows="10" required></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="mb-3 w-100">
                                <label class="w-100">Sender Details:</label>
<textarea class="w-100" id="sender_details" name="sender_details" rows="4" required>
Regards,
World Consumers Club
worldconsumerclub.com
9876987605
</textarea>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit"> Send </button>
                    </form>

                </div>

            </div>

        </div>

    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var companies = @json($companies);

            var companySelect = document.getElementById('company-select');
            var emailsSelect = document.getElementById('company-emails-select');

            companySelect.addEventListener('change', function() {
                var selectedCompanyId = this.value;
                var selectedCompany = companies.find(company => company.id == selectedCompanyId);

                // Clear existing options
                emailsSelect.innerHTML = '<option value="">Select an email</option>';

                if (selectedCompany) {
                    var emails = JSON.parse(selectedCompany.emails);
                    var contactPersons = JSON.parse(selectedCompany.contact_person);

                    // Add company emails
                    emails.forEach(function(email) {
                        var option = document.createElement('option');
                        option.value = email;
                        option.textContent = email;
                        emailsSelect.appendChild(option);
                    });

                    // Add contact person emails
                    contactPersons.forEach(function(person) {
                        var option = document.createElement('option');
                        option.value = person.email;
                        option.textContent = person.email + ' ( ' + person.name + ' )';
                        emailsSelect.appendChild(option);
                    });
                }
            });

            emailsSelect.addEventListener('change', function() {
                var reciverEmail = document.getElementById('reciver_email');
                reciverEmail.value = emailsSelect.value;
            });
        });





        $(document).ready(function() {
            $("#mail-form").validate({
                rules: {
                    reciver_email: {
                        required: true,
                    },
                    message: {
                        required: true,
                    },
                    subject:{
                        required:true
                    },
                    sender_details:{
                        required:true
                    }
                },
            });
        });
    </script>
@endpush
