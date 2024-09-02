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
                <h3 class="page-title"> Excluded Email List </h3>
            </div>
            <div class="  d-flex">
                <div class="mr-4">
                    <a href="{{ route('admin.daily-winners') }}">
                        <button class="btn btn-primary" style="text-wrap:nowrap">View Daily Winners</button>
                    </a>
                </div>
                <div class="mr-4">
                    <a href="{{ route('admin.monthly-winners') }}">
                        <button class="btn btn-primary" style="text-wrap:nowrap">View Monthly Winners</button>
                    </a>
                </div>
                <div>
                    <a href="{{ route('admin.candidates') }}">
                        <button class="btn btn-primary" style="text-wrap:nowrap">View Today's Winner Candidates</button>
                    </a>
                </div>
            </div>
        </div>
    </div>


    <div class="card col-md-12 my-4 ">

        <div class="card-body">

            <form method="POST" action="{{ route('store-excluded-email') }}" id="add-post" class="m-0">
                @csrf
                <div class="form-row ">
                    <div class="d-flex align-items-center">
                        <label class="m-auto" style="text-wrap: nowrap">Add Email : </label>
                        <input type="email" class="mx-4 form-control " style="width: 24rem;"  name="email" required>
                        <button class="btn btn-primary m-2 pt-0 pb-0" type="submit"> Add </button>
                    </div>
                </div>

            </form>

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
        <table id="excludedListTable" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th style="color: blue"><b>S.No.</b></th>
                    <th style="color: blue"><b>Email</b></th>
                    <th style="color: blue"><b>Action</b></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
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

            function createTable(joinSpan, userType, sortBy) {
                $('#excludedListTable').DataTable({
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
                        "url": "{{ route('fetch-excluded-candidates') }}",
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
                            "data": "email", //name in JSON response?
                            "name": "email" //column name in DB
                        },
                        {
                            "data": null, // This column will be populated dynamically
                            "name": "actions",
                            "orderable": false,
                            "searchable": false,
                            "render": function(data, type, row) {
                                return `
                        <button class="btn btn-sm btn-danger delete-btn" data-id="${row.id}">Delete</button>`;
                            }
                        },
                    ],
                    columnDefs: [{
                        orderable: false,
                        targets: 0,
                        searchable: true
                    }],

                });
            }

            $(document).on('click', '.delete-btn', function(event) {
                event.stopPropagation();
                const id = $(this).data('id');
                if (confirm("Are you sure you want to delete this email?")) {
                    $.ajax({
                        url: `delete-excluded-email/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                $('#excludedListTable').DataTable().ajax.reload();
                            } else {
                                alert("An error occurred while deleting the email.");
                            }
                        }
                    });
                }
            });


        });
    </script>
@endpush
