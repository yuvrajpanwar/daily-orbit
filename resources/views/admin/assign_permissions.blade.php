@extends('admin_layout/admin_app')

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h1 class="page-title">Assign Permissions</h1>
            </div> <!-- .col-12 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->

    <div class="row">

        <div class="col-md-6">

            <div class="card shadow mb-4">

                @if ($errors->any())
                    <div class="alert alert-danger show" id="alert-danger" name="alert-danger">
                        <a data-toggle="collapse" href="#alert-danger" role="button" aria-expanded="true"
                            aria-controls="alert-danger" class="btn-link close-button">X</a>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

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



                <div class="card-header ">

                    <strong class="card-title h5">Assign permissions to role</strong>

                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('store_assign_permissions') }}" class="" id="details"
                        name="details" enctype="multipart/form-data">
                        @csrf

                        <div class="form-row mb-3">
                            <div class="col-md-8 mb-3">


                                <label for="role_id" class="h6">Select Role</label>
                                <select class="form-control" name="role_id" id="" required>
                                    <option disabled selected value="">---Select role of user---</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ old('role') == 'role->name' ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <p class="h6">Select Permissions :</p>
                        <div class="form-row">
                            <div class="col-md-8">
                                <div class="mt-2">
                                    <input type="checkbox" class="" id="checkAll">
                                    <label class="  " for="">All Permissions</label>
                                </div>
                            </div>
                        </div>

                        <hr>

                        @foreach ($groupedPermissions as $group => $permissions)
                            <p class="h6">{{ $group }}</p>
                            <div class="form-row">
                                @foreach ($permissions as $permission)
                                    <div class="col-md-6 mb-3">
                                        <div class="">
                                            <input type="checkbox" class="permission" id="" name="permissions[]"
                                                value="{{ $permission->id }}">
                                            <label class="" for="">{{ $permission->name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach




                        <button class="btn btn-primary" type="submit">Save</button>

                    </form>

                </div>

            </div>

        </div>

    </div>

@endsection


@push('js')
    {{-- check all checkboxes --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkAll = document.getElementById('checkAll');
            const checkboxes = document.querySelectorAll('.permission');

            checkAll.addEventListener('change', function() {
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = checkAll.checked;
                });
            });

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    if (!checkbox.checked) {
                        checkAll.checked = false;
                    } else {
                        // Check if all other checkboxes are checked
                        const allChecked = Array.from(checkboxes).every(function(cb) {
                            return cb.checked;
                        });

                        checkAll.checked = allChecked;
                    }
                });
            });
        });
    </script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkAll = document.getElementById('checkAll');
            const checkboxes = document.querySelectorAll('.permission');
    
            checkAll.addEventListener('change', function() {
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = checkAll.checked;
                });
            });
    
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    if (!checkbox.checked) {
                        checkAll.checked = false;
                    } else {
                        // Check if all other checkboxes are checked
                        const allChecked = Array.from(checkboxes).every(function(cb) {
                            return cb.checked;
                        });
    
                        checkAll.checked = allChecked;
                    }
                });
            });
        });
    </script>
    

    {{-- fetch permissions of role --}}
    <script>
        console.log('here');
        document.addEventListener('DOMContentLoaded', function() {
            var roleSelect = document.querySelector('select[name="role_id"]');
            var permissionCheckboxes = document.querySelectorAll('.permission');

            roleSelect.addEventListener('change', function() {
                var selectedRoleId = roleSelect.value;

                var url = "{{ route('get_permissions', ':role_id') }}";
                url = url.replace(':role_id', selectedRoleId);
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        permissionCheckboxes.forEach(checkbox => {
                            checkbox.checked = false;
                        });
                        data.permissions.forEach(permission => {
                            var checkbox = document.querySelector('input[value="' + permission
                                .id + '"]');
                            if (checkbox) {
                                checkbox.checked = true;
                            }
                        });
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>

    {{-- form validations  --}}
    <script>
        $(document).ready(function() {
            $("#details").validate({
                rules: {
                    role_id: {
                        required: true,
                    }
                },
                messages: {
                    role_id: {
                        required: "Please Select Role !"
                    }
                }

            });
        });
    </script>
@endpush
