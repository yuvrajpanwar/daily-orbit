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
        input{
            margin-left: 1.5rem;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h3 class="page-title"> Categories (<span id="totalCategoriesCount"></span>) </h3>
            </div>
        </div>
    </div>

    <div class="container-fluid mb-4">
        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <a href="{{ route('admin.add-category') }}"><button class="btn btn-primary">Add New Category</button></a>
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

        <table id="categoriesTable" class="table table-striped" style="width:100%">

            <thead>
                <tr>
                    <th ><b class="h5">S.No.</b></th>
                    <th ><b class="h5">Name</b></th>
                    <th ><b class="h5">Publish</b></th>
                    <th ><b class="h5">Actions</b></th>
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
                    <p><strong>category Title :</strong></p>
                    <p id="modalcategoryTitle"></p>
                    <p><strong>category Description:</strong></p>
                    <p id="modalcategoryDescription"></p>
                    <p><strong>Author : </strong> <span id="modalcategoryAuthor"> </span></p>
                    <p><strong>Company : </strong> <span id="modalcategoryCompany"></span></p>
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
                $('#categoriesTable').DataTable({
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
                        "url": "{{ route('admin.fetch-all-categories') }}",
                        "data": function(d) {
                            d._token = "{{ csrf_token() }}";
                        },
                        "dataSrc": function(json) {
                            // Update the total categories count
                            $('#totalCategoriesCount').text(json.recordsTotal);
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
                            "data": "name",
                            "name": "name"
                        },
                       
                        {
                            "data": "is_active", // Column for visibility checkbox
                            "name": "is_active",
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
                                $('#modalcategoryTitle').text(data.category_title);
                                $('#modalcategoryDescription').text(data.category_description);
                                $('#modalcategoryAuthor').text(data.author);
                                $('#modalcategoryCompany').text(data.company);

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
                window.location.href = `edit-category/${id}`;
            });

            $(document).on('click', '.delete-btn', function(event) {
                event.stopPropagation();
                const id = $(this).data('id');
                if (confirm("Are you sure you want to delete this category?")) {
                    $.ajax({
                        url: `delete-category/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                $('#categoriesTable').DataTable().ajax.reload();
                                // alert("category deleted successfully.");
                            } else {
                                alert("An error occurred while deleting the category.");
                            }
                        }
                    });
                }
            });

            // Visibility checkbox change event
            $(document).on('change', '.visibility-checkbox', function() {
                const id = $(this).data('id');
                const isActive = $(this).is(':checked');

                $.ajax({
                    url: `update-category-visibility/${id}`,
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        is_active: isActive ? 1 : 0
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#categoriesTable').DataTable().ajax.reload();
                        } else {
                            alert("An error occurred while updating the category visibility.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log any errors
                        alert("An error occurred while updating the category visibility.");
                    }
                });
            });
        });
    </script>
@endpush
