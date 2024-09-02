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

        input {
            margin-left: 1.5rem;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h3 class="page-title"> Banners (<span id="totalBannersCount"></span>) </h3>
            </div>
        </div>
    </div>

    <div class="container-fluid mb-4">
        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <a href="{{ route('add-banner') }}"><button class="btn btn-primary">Add New banner</button></a>
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

        <table id="bannersTable" class="table table-striped" style="width:100%">

            <thead>
                <tr>
                    <th style="color: blue"><b>S.No.</b></th>
                    <th style="color: blue"><b>Page</b></th>
                    <th style="color: blue"><b>Column</b></th>
                    <th style="color: blue"><b>Banner Number</b></th>
                    <th style="color: blue"><b>Tab</b></th>
                    <th style="color: blue"><b>Start Date</b></th>
                    <th style="color: blue"><b>End Date</b></th>
                    <th style="color: blue"><b>Image</b></th>
                    <th style="color: blue"><b>Active</b></th>
                    <th style="color: blue"><b>Actions</b></th>
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
                    <form id="formDelete" class="" action="" method="">
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
                    <h5 class="modal-title">Banner Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Banner Link : </strong><span id="thisBannerHref"></span></p>
                </div>
                <div class="modal-body">
                    <img class="img-fluid" src="" alt="" id="thisBannerImage">
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

            // Initially create table
            createTable();

            function createTable() {
                $('#bannersTable').DataTable({
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
                        "url": "{{ route('fetch-all-banners') }}",
                        "data": function(d) {
                            d._token = "{{ csrf_token() }}";
                        },
                        "dataSrc": function(json) {
                            // Update the total Banners count
                            $('#totalBannersCount').text(json.recordsTotal);
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
                            "data": "Page",
                            "name": "page"
                        },
                        {
                            "data": "Column",
                            "name": "column",

                        },
                        {
                            "data": "bannerNumber",
                            "name": "banner_number"
                        },
                        {
                            "data": "tab",
                            "name": "tab",
                            "render": function(data, type, row) {
                                if (data == 'new_tab'){
                                    return 'New Tab';
                                }
                                else{
                                    return 'Same Tab';
                                }
                            }
                        },
                        {
                            "data": "startDate",
                            "name": "start_date"
                        },
                        {
                            "data": "end_date",
                            "name": "end_date",
                            "render": function(data, type, row) {
                                if (!data){
                                    return ' - ';
                                }
                                else{
                                    return data;
                                }
                            }
                        },
                        {
                            "data": "image",
                            "name": "image",
                            "render": function(data, type, row) {
                                return `<img width="50px" class="img-fluid" src="{{config('filesystems.disks.s3.url')}}/banners/${row.image}" > `;
                            }
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
                                return `
                        <button class="btn btn-sm btn-primary edit-btn" data-id="${row.id}">Edit</button>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="${row.id}">Delete</button>`;
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
                                    'visibility-checkbox')) {
                                $('#thisBannerImage').attr('src',
                                    `{{config('filesystems.disks.s3.url')}}/banners/${data.image}`);
                                $('#thisBannerHref').text(data.href);
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
                window.location.href = `edit-banner/${id}`;
            });

            $(document).on('click', '.delete-btn', function(event) {
                event.stopPropagation();
                const id = $(this).data('id');
                if (confirm("Are you sure you want to delete this banner?")) {
                    $.ajax({
                        url: `delete-banner/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                $('#bannersTable').DataTable().ajax.reload();
                                // alert("banner deleted successfully.");
                            } else {
                                alert("An error occurred while deleting the banner.");
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
                    url: `update-banner-visibility/${id}`,
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        is_visible: isVisible ? 1 : 0
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            // alert("Banner visibility updated successfully.");
                        } else {
                            alert("An error occurred while updating the banner visibility.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log any errors
                        alert("An error occurred while updating the banner visibility.");
                    }
                });
            });

        });
    </script>
@endpush
