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

        tr>td {
            cursor: pointer;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h3 class="page-title"> Interns (<span id="totalInternsCount"></span>) </h3>
            </div>
        </div>
    </div>

    {{-- filters --}}
    <div class="col-12 mb-3">
        <div class="card">
            <div class="card-body py-2">
                <div class="row">

                    <div class="col-lg-3" style="display:" data-select2-id="select2-data-6-ddvu">
                        <label for="department">Select Join Date</label>
                        <select name="joinSpan" id="joinSpan" class="w-100">
                            <option value="">All Time</option>
                            <option value="today">Today</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="this_week">This Week</option>
                            <option value="this_month">This Month</option>
                            <option value="last_month">Last Month</option>
                            <option value="this_year">This Year</option>
                        </select>
                    </div>

                    <div class="col-lg-3" style="display:" data-select2-id="select2-data-6-ddvu">
                        <label for="department">Select Gender</label>
                        <select name="gender" id="gender" class="w-100">
                            <option value="">Every One</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <div class="col-lg-3" style="display:" data-select2-id="select2-data-6-ddvu">
                        <label for="department">Select Age Group</label>
                        <select name="ageGroup" id="ageGroup" class="w-100">
                            <option value="">Every Age</option>
                            <option value="belowThirty">below thirty (<30) </option>
                            <option value="betweenThirtyFifty">Thirty to Fifty (30-50)</option>
                            <option value="aboveFifty">Above Fifty (>50)</option>
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

        <table id="internsTable" class="table table-striped" style="width:100%">

            <thead>
                <tr>
                    <th style="color: blue"><b>S.No.</b></th>
                    <th style="color: blue"><b>Name</b></th>
                    <th style="color: blue"><b>City</b></th>
                    <th style="color: blue"><b>State</b></th>
                    <th style="color: blue"><b>Pin</b></th>
                    <th style="color: blue"><b>Gender</b></th>
                    <th style="color: blue"><b>Join Date</b></th>
                </tr>
            </thead>

            <tbody>

            </tbody>



        </table>

    </div>

    <!-- delete pop up Modal -->
    <div class="modal fade" id="verticalModal" tabindex="-1" role="dialog" aria-labelledby="verticalModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verticalModalTitle">Delete !</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <b aria-hidden="true">X</b>
                    </button>
                </div>
                <div class="modal-body"> Are you sure you want to delete this user ?</div>
                <div class="modal-footer">
                    <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn mb-2 btn-danger" id="deleteButton">Yes</button>
                    <form id="formDelete" class="" action="" method="POST">
                        @method('DELETE')
                        @csrf
                    </form>
                </div>
            </div>
        </div>
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
@endsection

@push('js')
    {{-- for data table --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {

            // initially create table 
            createTable('', '', '');

            //on filter change create table again 
            $('#joinSpan').on('change', function() {
                joinSpan = $('#joinSpan').val();
                gender = $('#gender').val();
                ageGroup = $('#ageGroup').val();
                $('#internsTable').DataTable().destroy();
                createTable(joinSpan, gender, ageGroup);
            });
            $('#gender').on('change', function() {
                joinSpan = $('#joinSpan').val();
                gender = $('#gender').val();
                ageGroup = $('#ageGroup').val();
                $('#internsTable').DataTable().destroy();
                createTable(joinSpan, gender, ageGroup);
            });
            $('#ageGroup').on('change', function() {
                joinSpan = $('#joinSpan').val();
                gender = $('#gender').val();
                ageGroup = $('#ageGroup').val();
                $('#internsTable').DataTable().destroy();
                createTable(joinSpan, gender, ageGroup);
            });


            function createTable(joinSpan, gender, ageGroup) {
                $('#internsTable').DataTable({
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
                        "url": "{{ route('fetch-all-interns') }}",
                        "data": {
                            _token: "{{ csrf_token() }}",
                            'joinSpan': joinSpan,
                            'gender': gender,
                            'ageGroup': ageGroup
                        },
                        "dataSrc": function(json) {
                            // Update the total interns count
                            $('#totalInternsCount').text(json.recordsTotal);
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
                    ],
                    columnDefs: [{
                        orderable: false,
                        targets: 0,
                        searchable: true
                    }],
                    "rowCallback": function(row, data) {
                        $(row).on('click', function() {
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
                        });
                    }
                });
            }

        });
    </script>
@endpush
