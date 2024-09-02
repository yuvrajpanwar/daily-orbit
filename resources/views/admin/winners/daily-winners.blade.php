@extends('admin/admin-layout/admin-app')

@push('css')
    <style type="text/css">
        .error {
            color: red;
        }

        #alert-success {
            transition-duration: 0.3s;
            transition-timing-function: ease-in-out;
        }

        .close-button {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            color: #333;
            text-decoration: none;
        }

        tr>td {
            cursor: pointer;
        }

        td.only-info {
            cursor: default !important;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid mb-4">
        <div class="row justify-content-between">
            <div>
                <h3 class="page-title"> Daily Winners </h3>
            </div>
            <div class=" d-flex">
                <div class="mr-4">
                    <a href="{{ route('admin.monthly-winners') }}">
                        <button class="btn btn-primary" style="text-wrap:nowrap">View Monthly Winners</button>
                    </a>
                </div>
                <div class="mr-4">
                    <a href="{{ route('admin.candidates') }}">
                        <button class="btn btn-primary" style="text-wrap:nowrap">View Today's Winner Candidates</button>
                    </a>
                </div>
                <div>
                    <a href="{{ route('admin.excluded-list') }}">
                        <button class="btn btn-primary" style="text-wrap:nowrap">Excluded List</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mb-4">

        @if (session('success'))
            <div class="alert alert-success show" id="alert-success">
                <a data-toggle="collapse" href="#alert-success" role="button" aria-expanded="true"
                    aria-controls="alert-success" class="btn-link close-button">x</a>
                {{ session('success') }}
            </div>
        @endif
        <table id="dailyWinnersTable" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th style="color: blue"><b>S.No.</b></th>
                    <th style="color: blue"><b>Winning Date</b></th>
                    <th style="color: blue"><b>Name</b></th>
                    <th style="color: blue"><b>City</b></th>
                    <th style="color: blue"><b>State</b></th>
                    <th style="color: blue"><b>Pin</b></th>
                    <th style="color: blue"><b>Gender</b></th>
                    <th style="color: blue"><b>DP</b></th>
                    <th style="color: blue"><b>Total People Added</b></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

    </div>


    <!--all details Modal Structure -->
    <div id="detailsModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">All Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="position: relative">
                    <p><strong>First Name:</strong> <span id="modalFirstName"></span></p>
                    <p><strong>Last Name:</strong> <span id="modalLastName"></span></p>
                    <p><strong>Email:</strong> <span id="modalEmail"></span></p>
                    <p><strong>Mobile Number:</strong> <span id="modalMobileNumber"></span></p>
                    <p><strong>Date Of Birth:</strong> <span id="modalDateOfBirth"></span></p>
                    <p><strong>City:</strong> <span id="modalCity"></span></p>
                    <p><strong>State:</strong> <span id="modalState"></span></p>
                    <p><strong>Pin:</strong> <span id="modalPin"></span></p>
                    <p><strong>Country:</strong> <span id="modalCountry"></span></p>
                    <p><strong>Gender:</strong> <span id="modalGender"></span></p>
                    <p><strong>Occupation:</strong> <span id="modalOccupation"></span></p>
                    <p><strong>Join Date:</strong> <span id="modalJoinDate"></span></p>
                    <p><strong>Referred By:</strong> <span id="modalReferredBy"></span></p>

                    <div class="dp-container" style="position: absolute;top:1rem;right:1rem;">
                        <img src="" alt="" id="dp" height="100px" width="100px" alt="no-image">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- referrals list  --}}
    <div id="referralsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: fit-content!important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Referred Users</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Table to display referred users -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Joined Date</th>
                            </tr>
                        </thead>
                        <tbody id="dailyWinnersTableBody">
                            <!-- Dynamic content will be injected here -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    {{-- for data table --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        function formatDate(sqlDate) {
            let date = new Date(sqlDate);
            let day = String(date.getDate()).padStart(2, '0');
            let month = String(date.getMonth() + 1).padStart(2, '0');
            let year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }

        $(document).ready(function() {

            // initially create table 
            createTable('', '', '');

            //on filter change create table again 
            $('#userType').on('change', function() {
                joinSpan = $('#joinSpan').val();
                userType = $('#userType').val();
                $('#dailyWinnersTable').DataTable().destroy();
                createTable(joinSpan, userType);
            });

            function createTable(joinSpan, userType, sortBy) {
                $('#dailyWinnersTable').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "lengthMenu": [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"]
                    ],
                    'bLengthChange': true,
                    'paging': true,
                    'pageLength': 10,
                    "ordering": false,
                    "ajax": {
                        "url": "{{ route('fetch-daily-winners') }}",
                        "data": {
                            _token: "{{ csrf_token() }}",
                            'joinSpan': joinSpan,
                            'userType': userType,
                            'sortBy': sortBy
                        },
                        "dataSrc": function(json) {
                            // Update the total member count
                            // $('#totalMembersCount').text(json.recordsTotal);
                            return json.data;
                        }
                    },
                    "columns": [{
                            "data": 'DT_RowIndex',
                            "name": 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            "data": "winningDate",
                            "name": "winning_date"
                        },
                        {
                            "data": "Name", //name in JSON response?
                            "name": "users.first_name" //column name in DB
                        },
                        {
                            "data": "city_town",
                            "name": "users.city_town"
                        },
                        {
                            "data": "state",
                            "name": "users.state"
                        },
                        {
                            "data": "pin_code",
                            "name": "users.pin_code"
                        },
                        {
                            "data": "gender",
                            "name": "users.gender"
                        },
                        {

                            "data": null, // This column will be populated dynamically
                            "name": "actions",
                            "orderable": false,
                            "searchable": false,
                            "render": function(data, type, row) {
                                return (data.profile_picture) ? 'Yes' : 'No';
                            }

                        },
                        {
                            "data": null, // This column will be populated dynamically
                            "name": "actions",
                            "orderable": false,
                            "searchable": false,
                            "render": function(data, type, row) {
                                return `  
                                <button id="this-users-referrals" class="this-users-referrals btn btn-sm btn-primary edit-btn" data-id="${row.id}">( ${row.Referrals} ) View List</button>
                                `;
                            }
                        },
                    ],
                    columnDefs: [{
                        orderable: false,
                        targets: 0,
                        searchable: true
                    }],
                    "rowCallback": function(row, data) {
                        $(row).on('click', function(event) {
                            if (!$(event.target).hasClass('this-users-referrals')) {
                                $('#modalFirstName').text(data.first_name);
                                $('#modalLastName').text(data.last_name);
                                $('#modalEmail').text(data.email);
                                $('#modalMobileNumber').text(data.mobile_number);
                                $('#modalDateOfBirth').text(data.DateOfBirth);
                                $('#modalCity').text(data.city_town);
                                $('#modalState').text(data.state);
                                $('#modalPin').text(data.pin_code);
                                $('#modalCountry').text(data.country);
                                $('#modalGender').text(data.gender);
                                $('#modalOccupation').text(data.occupation);
                                $('#modalJoinDate').text(formatDate(data.created_at));
                                if (data.referred_by != null) {
                                    $('#modalReferredBy').text(data.referred_by);
                                } else {
                                    $('#modalReferredBy').text('');
                                }
                                if (data.profile_picture) {
                                    $('#dp').attr('src',
                                            '{{ config('filesystems.disks.s3.url') . '/profile_pictures/' }}' +
                                            data.profile_picture)
                                        .show();
                                } else {
                                    $('#dp').hide();
                                }
                                // Show the modal
                                $('#detailsModal').modal('show');

                            }
                        });
                    }
                });
            }

            $(document).on('click', '.this-users-referrals', function(event) {
                event.stopPropagation();
                const id = $(this).data('id');
                console.log(id);

                $.ajax({
                    url: "{{ route('fetch-referred-users') }}", // Replace with your route to fetch referred users
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        user_id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            let referrals = response.data;
                            let tableBody = '';

                            referrals.forEach(function(referral) {
                                tableBody += `
                        <tr>
                            <td class="only-info">${referral.name}</td>
                            <td class="only-info" >${referral.email}</td>
                            <td class="only-info" >${referral.joined_date}</td>
                        </tr>
                    `;
                            });
                            if (referrals.length == 0) {
                                tableBody +=
                                    `<tr><td class="text-center" colspan="3"> No Users </td></tr>`;
                            }

                            $('#dailyWinnersTableBody').html(tableBody);
                            $('#referralsModal').modal('show');
                        } else {
                            alert('Failed to fetch referred users.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching referred users:', error);
                        alert('An error occurred while fetching referred users.');
                    }
                });
            });


        });
    </script>
@endpush
