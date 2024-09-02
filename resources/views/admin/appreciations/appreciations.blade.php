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

        input {
            margin-left: 1.5rem;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h3 class="page-title"> Appreciations (<span id="totalAppreciationsCount"></span>) </h3>
            </div>
        </div>
    </div>

    <div class="container-fluid mb-4">

        @if (session('success'))
            <div class="alert alert-success show" id="alert-success">
                <a data-toggle="collapse" href="#alert-success" role="button" aria-expanded="true"
                    aria-controls="alert-success" class="btn-link close-button">X</a>
                {{ session('success') }}
            </div>
        @endif

        <table id="appreciationsTable" class="table table-striped" style="width:100%">

            <thead>
                <tr>
                    <th style="color: blue"><b>S.No.</b></th>
                    <th style="color: blue"><b>Company</b></th>
                    <th style="color: blue"><b>Description</b></th>
                    <th style="color: blue"><b>Date</b></th>
                    <th style="color: blue"><b>Visibility</b></th>
                    <th style="color: blue"><b>Actions</b></th>
                    <th style="color: blue"><b>Post</b></th>

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

                    <p><strong>Description:</strong></p>
                    <p id="modalAppreciationDescription"></p>
                    <p><strong>Member Name : </strong> <span id="modalAppreciationMemberName"></span> <strong> Company :
                        </strong> <span id="modalAppreciationCompany"></span><strong>
                            <br>
                            City : </strong> <span id="modalAppreciationCity"></span> <strong> Pin : </strong> <span
                            id="modalAppreciationPin"></span></p>
                    <hr>
                    <p><strong>Title By Admin : </strong></p>
                    <p id="modalTitleByAdmin"></p>
                    <p><strong>Description By Admin : </strong></p>
                    <p id="modalDescriptionByAdmin"></p>
                    <p><strong>Company Name By Admin : </strong>
                        <span id="modalCompanyNameByAdmin"></span>
                    </p>
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
        function truncateText(text, wordLimit) {
            const words = text.split(' ');
            if (words.length > wordLimit) {
                return words.slice(0, wordLimit).join(' ') + '...';
            }
            return text;
        }
        $(document).ready(function() {


            // Initially create table
            createTable();

            function createTable() {
                $('#appreciationsTable').DataTable({
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
                        "url": "{{ route('fetch-all-appreciations') }}",
                        "data": function(d) {
                            d._token = "{{ csrf_token() }}";
                        },
                        "dataSrc": function(json) {
                            // Update the total appreciations count
                            $('#totalAppreciationsCount').text(json.recordsTotal);
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
                            "data": "CompanyName",
                            "name": "company_name"
                        },
                        {
                            "data": "Description",
                            "name": "description",
                            "render": function(data, type, row) {
                                return truncateText(data, 7);
                            }
                        },
                        {
                            "data": "Date",
                            "name": "created_at"
                        },
                        {
                            "data": "is_visible", // Column for visibility checkbox
                            "name": "is_visible",
                            "orderable": false,
                            "searchable": false,
                            "render": function(data, type, row) {
                                return `
                        <input type="checkbox" class="visibility-checkbox" data-id="${row.id}" ${data ? 'checked' : ''}>
                    `;
                            }
                        },
                        {
                            "data": null, // This column will be populated dynamically
                            "name": "actions",
                            "orderable": false,
                            "searchable": false,
                            "render": function(data, type, row) {
                                if (data.title_by_admin) {
                                    return `
                                    <button class="btn btn-sm btn-success edit-btn" data-id="${row.id}">Edited</button>
                                            <button class="btn btn-sm btn-danger delete-btn" data-id="${row.id}">Delete</button>
                                            <button class="btn btn-sm btn-primary mail-btn" data-id="${row.id}"><i class="fe fe-16 fe-mail "></i></button>`;
                                } else {
                                    return `
                                    <button class="btn btn-sm btn-primary edit-btn" data-id="${row.id}">Edit</button>
                                            <button class="btn btn-sm btn-danger delete-btn" data-id="${row.id}">Delete</button>
                                            <button class="btn btn-sm btn-primary mail-btn" data-id="${row.id}"><i class="fe fe-16 fe-mail "></i></button>`;
                                }
                            }
                        }, {
                            "data": null,
                            "name": "post",
                            "searchable": false,
                            "render": function(data, type, row) {
                                return `<button class="btn btn-sm btn-primary post-btn" data-id="${row.id}"><i class="fe fe-16 fe-edit"></i></button>`
                            }
                        }
                    ],
                    "columnDefs": [{
                        orderable: false,
                        targets: 0,
                        searchable: true
                    }],
                    "rowCallback": function(row, data) {
                        // Row click handler for other actions
                        $(row).on('click', function(event) {
                            // Prevent action if it's a button click
                            if (!$(event.target).hasClass('edit-btn') && !$(event.target)
                                .hasClass('delete-btn') && !$(event.target).hasClass(
                                    'visibility-checkbox') && !$(event.target).hasClass(
                                    'mail-btn') && !$(event.target).hasClass('fe')) {
                                $('#modalAppreciationDescription').text(data.description);
                                $('#modalAppreciationMemberName').text(data.member_name);
                                $('#modalAppreciationCity').text(data.city_town);
                                $('#modalAppreciationCompany').text(data.company_name);
                                $('#modalAppreciationPin').text(data.pin_code);
                                $('#modalTitleByAdmin').text(data.title_by_admin);
                                $('#modalDescriptionByAdmin').text(data.description_by_admin);
                                $('#modalCompanyNameByAdmin').text(data.company_name_by_admin);
                                // Show the modal
                                $('#detailsModal').modal('show');
                            }
                        });
                    }
                });
            }

            // Action buttons using delegated event handling
            $(document).on('click', '.edit-btn', function(event) {
                event.stopPropagation();
                const id = $(this).data('id');
                window.location.href = `edit-appreciation/${id}`;
            });

            $(document).on('click', '.mail-btn', function(event) {
                event.stopPropagation();
                const id = $(this).data('id');
                window.location.href = `mail-appreciation/${id}`;
            });

            $(document).on('click', '.post-btn', function(event) {
                event.stopPropagation();
                const id = $(this).data('id');
                window.location.href = `add-post/appreciation/${id}`;
            });

            $(document).on('click', '.delete-btn', function(event) {
                event.stopPropagation();
                const id = $(this).data('id');
                if (confirm("Are you sure you want to delete this appreciation?")) {
                    $.ajax({
                        url: `delete-appreciation/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                $('#appreciationsTable').DataTable().ajax.reload();
                                // alert("appreciation deleted successfully.");
                            } else {
                                alert("An error occurred while deleting the appreciation.");
                            }
                        }
                    });
                }
            });

            // Visibility checkbox change event
            $(document).on('change', '.visibility-checkbox', function() {
                const id = $(this).data('id');
                const isVisible = $(this).is(':checked');

                $.ajax({
                    url: `update-appreciation-visibility/${id}`,
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        is_visible: isVisible ? 1 : 0
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            // alert("appreciation visibility updated successfully.");
                        } else {
                            alert(
                                "An error occurred while updating the appreciation visibility.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log any errors
                        alert("An error occurred while updating the appreciation visibility.");
                    }
                });
            });
        });
    </script>
@endpush
