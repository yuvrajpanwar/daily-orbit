@extends('admin/admin-layout/admin-app')

@push('css')
    <link rel="stylesheet" href="{{ asset('admin/snapselect.css') }}">
    <script src="{{ asset('admin/snapselect.js') }}"></script>
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
                <h3 class="page-title">Send Emails</h3>
            </div>
        </div>
    </div>
    <div class="container-fluid mb-4">
        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <a href="{{ route('email-templates') }}" class="mr-4"><button class="btn btn-primary">Email
                        Templates</button></a>
                <a href="{{ route('email-formats') }}"><button class="btn btn-primary">Manage Email Formats</button></a>
            </div>
        </div>
    </div>
    <div class="container-fluid mb-4">

        @if (session('success'))
            <div class="alert alert-success show col-md-8" id="alert-success">
                <a data-toggle="collapse" href="#alert-success" role="button" aria-expanded="true"
                    aria-controls="alert-success" class="btn-link close-button">X</a>
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger col-md-8">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">

            <div class="card col-md-8">

                <div class="card-body">

                    <form method="POST" action="{{ route('send-emails') }}" name="mail-form" id="mail-form">
                        @csrf

                        <div class="form-row">
                            <div class="mb-3 w-100">
                                <label>Select Recipients:</label>
                                <select name="recipients" id="recipients" class="recipients form-control w-100" required>
                                    <option value="all_members">All Members</option>
                                    <option value="all_interns">All Interns</option>
                                    <option value="daily_winners">Daily Winners</option>
                                    <option value="monthly_winners">Monthly Winners</option>
                                    <option value="never_won">Members who have never won</option>
                                    <option value="referred_to_others">Members who have referred to others</option>
                                    <option value="not_referred_to_others">Members who have not referred to others</option>
                                    <option value="select_users">Select Users Manually</option>
                                    <option value="enter_email_addresses">Enter Email Addresses</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row" id="user-list-container" style="display: none">
                            <div class="mb-3 w-100">
                                <label>Select Users:</label>
                                <select name="users-list[]" id="users-list" class="users-list form-control w-100" required
                                    multiple>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" data-key="{{ $user->id }}">
                                            {{ $user->first_name . ' ' . $user->last_name . ' (' . $user->email . ')' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row" id="email_addresses" style="display: none">
                            <div class="mb-3 w-100">
                                <label>To: (Enter Comma Seperated Email Addresses)</label>
                                <input class="form-control" type="text" name="email_addresses" placeholder="Enter Email">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="mb-3 w-100">
                                <label>Select Email Template:</label>
                                <select name="email-template" class="form-control w-100" required>
                                    <option value="" selected disabled class="text-center">---Select Email Template---
                                    </option>
                                    <option value="letter-template">Letter Template</option>
                                    <option value="blank-template">Blank Template</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="mb-3 w-100">
                                <label>Select Email Format:</label>
                                <select id="email-format" class="form-control w-100">
                                    <option value="" selected disabled class="text-center">---select email format---
                                    </option>
                                    @foreach ($email_formats as $format)
                                        <option value="{{ $format->id }}" data-format-name="{{ $format->format_name }}"
                                            data-message="{{ $format->message }}">
                                            {{ $format->format_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="mb-3 w-100">
                                <label>Subject:</label>
                                <input type="text" class="form-control w-100" name="subject" id="subject" required
                                    placeholder="Enter Subject" required>
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
World Consumer Club
worldconsumerclub.com
9876987605
</textarea>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit" id="submit-button"> Send </button>
                    </form>

                </div>

            </div>

        </div>

    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {

            SnapSelect('.users-list', {
                liveSearch: true,
                placeholder: 'Select Recipients',
                clearAllButton: false,
                selectOptgroups: false,
                selectAllOption: false,
                closeOnSelect: false,
                maxSelections: Infinity,
                allowEmpty: false,
            });

            document.getElementById('recipients').addEventListener('change', function() {
                if (this.value === 'select_users') {
                    $('#user-list-container').show();
                } else {
                    $('#user-list-container').hide();
                }
                if (this.value === 'enter_email_addresses') {
                    $('#email_addresses').show();
                } else {
                    $('#email_addresses').hide();
                }
            });

            $(document).ready(function() {
                $('#email-format').on('change', function() {
                    // Get the selected option
                    var selectedOption = $(this).find('option:selected');

                    // Retrieve the format name and message from the selected option
                    var formatName = selectedOption.data('format-name');
                    var message = selectedOption.data('message');

                    // Set the subject input and message textarea with the retrieved values
                    $('#subject').val(formatName);
                    $('#message').val(message);
                });
            });


            $(document).ready(function() {
                // Add custom method for validating comma-separated email addresses
                $.validator.addMethod("multiemail", function(value, element) {
                    if (this.optional(element)) {
                        return true;
                    }
                    var emails = value.split(',').map(function(email) {
                        return email.trim();
                    }).filter(Boolean);

                    return emails.every(function(email) {
                        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(
                            email); // Simple email regex
                    });
                }, "Please enter valid email addresses separated by commas.");

                // Initialize validation
                $("#mail-form").validate({
                    rules: {
                        email_addresses: {
                            required: {
                                depends: function(element) {
                                    return $('#recipients').val() === 'enter_email_addresses';
                                }
                            },
                            multiemail: {
                                depends: function(element) {
                                    return $('#recipients').val() === 'enter_email_addresses';
                                }
                            }
                        },
                        subject: {
                            required: true
                        },
                        message: {
                            required: true
                        },
                        sender_details: {
                            required: true
                        },
                        'users-list[]': {
                            required: {
                                depends: function(element) {
                                    return $('#recipients').val() === 'select_users';
                                }
                            }
                        }
                    },
                    messages: {
                        email_addresses: {
                            required: "Please enter email addresses.",
                            multiemail: "Please enter valid email addresses separated by commas."
                        },
                        'users-list[]': {
                            required: "Please select at least one user."
                        }
                    },
                    submitHandler: function(form) {
                        // Disable the button
                        $('#submit-button').prop('disabled', true);
                        // Change the button text
                        $('#submit-button').text('Wait...');
                        // Submit the form
                        form.submit();
                    }
                });

                // Handle recipient selection change
                $('#recipients').on('change', function() {
                    var recipientValue = $(this).val();

                    if (recipientValue === 'select_users') {
                        $('#users-list').rules('add', {
                            required: true
                        });
                        $('#email_addresses').rules('remove', 'required multiemail');
                    } else if (recipientValue === 'enter_email_addresses') {
                        $('#users-list').rules('remove', 'required');
                        $('#email_addresses').rules('add', {
                            required: true,
                            multiemail: true
                        });
                    } else {
                        $('#users-list').rules('remove', 'required');
                        $('#email_addresses').rules('remove', 'required multiemail');
                    }
                });

            });



        });
    </script>
@endpush
