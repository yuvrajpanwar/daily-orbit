@extends('admin_layout/admin_app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h1 class="page-title">Add New Permission </h1>
            </div> <!-- .col-12 -->
        </div> <!-- .row -->
    </div>

    <div class="row">

        <div class="col-md-6">

            <div class="card shadow mb-4">

                @if (session('success'))
                    <div class="alert alert-success show" id="alert-success">
                        <a data-toggle="collapse" href="#alert-success" role="button" aria-expanded="true"
                            aria-controls="alert-success" class="btn-link close-button float-right">X</a>
                        {{ session('success') }}

                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger show" id="alert-success">
                        <a data-toggle="collapse" href="#alert-success" role="button" aria-expanded="true"
                            aria-controls="alert-success" class="btn-link close-button float-right">X</a>
                        {{ session('error') }}

                    </div>
                @endif

                <div class="card-body">

                    <form method="POST" action="{{ route('store_permission') }}" class="permission_details"
                        id="permission_details" name="permission_details">
                        @csrf

                        <div class="form-row">
                            <div class="col-md-8 mb-3">
                                <label for="group_name">Select Group</label>
                                <select class="form-control" name="group_name" id="group_name" required>
                                    <option disabled>---Select Group_name---</option>
                                    <option value="Order" {{ old('group_name') == 'Order' ? 'selected' : '' }}>Order</option>
                                    <option value="Category" {{ old('group_name') == 'Category' ? 'selected' : '' }}>Category</option>
                                    <option value="Product" {{ old('group_name') == 'Product' ? 'selected' : '' }}>Product</option>
                                    <option value="Customer" {{ old('group_name') == 'Customer' ? 'selected' : '' }}>Customer</option>
                                    <option value="Sales" {{ old('group_name') == 'Sales' ? 'selected' : '' }}>Sales</option>
                                    <option value="Users" {{ old('group_name') == 'Users' ? 'selected' : '' }}>Users</option>
                                    <option value="Role" {{ old('group_name') == 'Role' ? 'selected' : '' }}>Role</option>
                                    <option value="Permission" {{ old('group_name') == 'Permission' ? 'selected' : '' }}>Permission</option>
                                    <option value="Report" {{ old('group_name') == 'Report' ? 'selected' : '' }}>Reports</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-8 mb-3">
                                <label for="name">Select Permission</label>
                                <select class="form-control" name="name" id="name" required>
                                    <option disabled>---Select name---</option>
                                    <option value="View" {{ old('name') == 'View' ? 'selected' : '' }}>View</option>
                                    <option value="Add" {{ old('name') == 'Add' ? 'selected' : '' }}>Add</option>
                                    <option value="Update" {{ old('name') == 'Update' ? 'selected' : '' }}>Update</option>
                                    <option value="Delete" {{ old('name') == 'Delete' ? 'selected' : '' }}>Delete</option>

                                </select>
                            </div>

                        </div>

                        <button class="btn btn-primary" type="submit"> Add </button>
                    </form>

                </div>

            </div>

        </div>

    </div>
@endsection


@push('js')
    {{-- form validations  --}}
    <script>
        $(document).ready(function() {
            $("#admin_details").validate({
                rules: {
                    name: {
                        required: true,
                    },
                    group_name: {
                        required: true,
                        email: true
                    },

                },
                messages: {
                    name: {
                        required: "Please enter your name !"
                    },
                    group_name: {
                        required: "Please select group !"
                    },

                }

            });
        });
    </script>
@endpush
