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

        .footer p {
            font-size: .8rem;
        }

        hr {
            border: 1px solid #F2EBEB;
        }

        .bottom-img img {
            width: 100%;
            height: auto;
            object-fit: cover;
            object-position: center;
        }

        @media screen and (min-width: 1024px) {

            .body {
                padding: 0 4rem;
            }
        }


        @media screen and (max-width: 1024px) {
            .body {
                padding: 0;
            }

            .bottom-img img {
                min-height: 95px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h3 class="page-title">Email Templates</h3>
            </div>
        </div>
    </div>
    <div class="container-fluid mb-4">
        <div class="row ">
            <div class="col-12 d-flex justify-content-end">
                <a href="{{ route('send-emails') }}" class="mr-4"><button class="btn btn-primary"><i
                            class="fe fe-16 fe-arrow-left"></i>Send Emails</button></a>
                <a href="{{ route('email-formats') }}"><button class="btn btn-primary">Manage Email Formats</button></a>
            </div>
        </div>
    </div>

    <div class="container-fluid mb-4">

        <div class="row" style="gap: 2rem">

            <div class="card col-12">
                <p>Letter Template</p>
                <div class="card-body">

                    <div class="body">

                        <div class="header"
                            style="display: flex; justify-content: flex-end; width: 100%; margin-top: 20px; margin-bottom: 20px;">
                            <div style="display: flex; align-items: center; margin-left: auto;">
                                <img class="logo-img" src="{{ asset('img/logo-2.png') }}" alt="Logo"
                                    style="height: 4.5rem; width: auto; margin-left: 1rem;">
                            </div>
                        </div>

                        <div class="main-content" style="min-height: 10rem; margin: 0;">
                            <p style="text-align: justify;">---your message will come here----</p>
                            <p style="text-align: justify;">---your message will come here----</p>
                            <p style="text-align: justify;">---your message will come here----</p>
                            <p>---Sender Details will come here---</p>
                            <br>
                        </div>

                        <div class="footer" style="font-size: .8rem;">
                            <p style="margin: 0;">Devanahalli, Bangalore-562 110 INDIA <a
                                    href="http://www.WorldConsumerClub.com" target="_blank"
                                    style="margin-left: 4px;">www.WorldConsumerClub.com</a></p>
                            <hr>
                            <div class="content">
                                <p style="margin: 0; text-align: justify;">World Consumer Club is founded for assisting
                                    consumers to
                                    take
                                    their appreciations and grievances to manufacturers, service providers, and
                                    organizations. We don’t
                                    try
                                    to solve every individual problem, but focus on reaching the concerns to the right
                                    people so that
                                    improvements are made in their respective operations to prevent unhappy situations with
                                    the
                                    consumers.
                                    It’s the consumer that drives the economy and their welfare is of great importance.
                                    Without
                                    consumers
                                    there is no business and therefore the importance of consumer satisfaction is paramount.
                                    We have
                                    observed that every founder and business owner want to have their consumers happy and
                                    their brand
                                    value
                                    goes up always. But many times, they do not come to know about the last mile issues and
                                    difficulties
                                    faced by the consumers. That is what we want to improve in the very first phase of our
                                    operations.
                                    Organizations are listening and taking steps to grasp the challenges and it’s a good
                                    sign. Moving
                                    forward we shall be able to reduce the communications and understanding gap between
                                    these two very
                                    important segments of the market. We encourage every organization to depute a dedicated
                                    consumer
                                    grievances officer who can receive the inputs from us and initiate remedial measures.
                                    These efforts
                                    seem
                                    to vastly make a difference to several organizations that we are interacting with. Let
                                    us work
                                    together
                                    to make life easier for the consumers which in turn will greatly benefit the
                                    organizations.
                                    Consumers
                                    are happy to share their concerns and businesses are glad to receive feedback, which is
                                    a great
                                    achievement for us to move forward with confidence. More and more organizations are
                                    getting
                                    connected
                                    with us each day, offering their support.</p>
                            </div>
                            <div class="bottom-img"
                                style="height: 100%; overflow: hidden; align-items: center;">
                                <img src="{{ asset('img/Group4.png') }}" alt="Footer Image"
                                    style="width: 100%; object-fit: cover; object-position: center;">
                            </div>
                        </div>
                        <hr>

                    </div>

                </div>
            </div>

            <div class="card col-12">

                <p>Blank Template</p>
                <div class="card-body">
                    <div class="main-content" style="min-height: 10rem; margin: 0;">
                        <p style="text-align: justify;">---your message will come here----</p>
                        <p style="text-align: justify;">---your message will come here----</p>
                        <p style="text-align: justify;">---your message will come here----</p>
                        <p>---Sender Details will come here---</p>
                        <br>
                    </div>

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

            // Add custom method for validating comma-separated email addresses
            $.validator.addMethod("multiemail", function(value, element) {
                if (this.optional(element)) {
                    return true;
                }
                var emails = value.split(',');
                var valid = true;
                for (var i = 0; i < emails.length; i++) {
                    var email = emails[i].trim();
                    if (!email.match(/^([a-zA-Z0-9_.+-])+@([a-zA-Z0-9-])+\.([a-zA-Z0-9]{2,4})+$/)) {
                        valid = false;
                        break;
                    }
                }
                return valid;
            }, "Please enter valid email addresses separated by commas.");

            $("#mail-form").validate({
                rules: {
                    email_addresses: {
                        required: true,
                        multiemail: true // Use the custom method for email validation
                    },
                    subject: {
                        required: true
                    },
                    message: {
                        required: true,
                    },
                    sender_details: {
                        required: true
                    }
                }
            });


        });
    </script>
@endpush
