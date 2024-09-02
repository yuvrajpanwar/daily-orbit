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
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h3 class="page-title"> Referrals </h3>
            </div>
        </div>
    </div>

    {{-- filters --}}
    <div class="col-12 mb-3">
        <div class="card">
            <div class="card-body py-2">
                <div class="row">

                    {{-- <div class="col-lg-3" data-select2-id="select2-data-6-ddvu">
                        <label for="joinSpan">Select Join Date</label>
                        <select name="joinSpan" id="joinSpan" class="w-100">
                            <option value="">All Time</option>
                            <option value="today">Today</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="this_week">This Week</option>
                            <option value="this_month">This Month</option>
                            <option value="last_month">Last Month</option>
                            <option value="this_year">This Year</option>
                        </select>
                    </div> --}}

                    <div class="col-lg-3" data-select2-id="select2-data-6-ddvu">
                        <label for="userType">Select User Type</label>
                        <select name="userType" id="userType" class="w-100">
                            <option value="all">All</option>
                            <option value="member">Member</option>
                            <option value="intern">Intern</option>
                        </select>
                    </div>

                    <div class="col-lg-3" data-select2-id="select2-data-6-ddvu">
                        <label for="sortBy">Sort By</label>
                        <select name="sortBy" id="sortBy" class="w-100">
                            <option value=""> Most People Added </option>
                            <option value="recentActivity"> Recent Activity </option>
                        </select>
                    </div>

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
        <table id="referralsTable" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th style="color: blue"><b>S.No.</b></th>
                    <th style="color: blue"><b>Name</b></th>
                    <th style="color: blue"><b>City</b></th>
                    <th style="color: blue"><b>State</b></th>
                    <th style="color: blue"><b>Pin</b></th>
                    <th style="color: blue"><b>Gender</b></th>
                    <th style="color: blue"><b>Join Date</b></th>
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
                <div class="modal-body">
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
                        <tbody id="referralsTableBody">
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
        $(document).ready(function() {

            // initially create table 
            createTable('', '','');

            //on filter change create table again 
            $('#joinSpan').on('change', function() {
                joinSpan = $('#joinSpan').val();
                gender = $('#gender').val();
                $('#referralsTable').DataTable().destroy();
                createTable(joinSpan, userType);
            });
            $('#userType').on('change', function() {
                joinSpan = $('#joinSpan').val();
                userType = $('#userType').val();
                $('#referralsTable').DataTable().destroy();
                createTable(joinSpan, userType);
            });
            $('#sortBy').on('change', function() {
                joinSpan = $('#joinSpan').val();
                userType = $('#userType').val();
                sortBy = $('#sortBy').val();
                $('#referralsTable').DataTable().destroy();
                createTable(joinSpan, userType, sortBy);
            });

            function createTable(joinSpan, userType, sortBy) {
                $('#referralsTable').DataTable({
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
                        "url": "{{ route('fetch-all-referrals') }}",
                        "data": {
                            _token: "{{ csrf_token() }}",
                            'joinSpan': joinSpan,
                            'userType': userType,
                            'sortBy' : sortBy
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
                            "data": "Name", //name in JSON response?
                            "name": "first_name" //column name in DB
                        },
                        {
                            "data": "City",
                            "name": "city_town"
                        },
                        {
                            "data": "State",
                            "name": "state"
                        },
                        {
                            "data": "Pin",
                            "name": "pin_code"
                        },
                        {
                            "data": "Gender",
                            "name": "gender"
                        },
                        {
                            "data": "JoinDate",
                            "name": "created_at"
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
                                $('#modalJoinDate').text(data.JoinDate);
                                // Show the modal
                                $('#detailsModal').modal('show');

                            }
                        });
                    }
                });
            }

            $(document).on('click', '.this-users-referrals', function(event) {
                event.stopPropagation();
                console.log('clicked');
                const id = $(this).data('id');

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

                            $('#referralsTableBody').html(tableBody);
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
