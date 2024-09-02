@extends('admin/admin-layout/admin-app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">


                    {{-- members --}}
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow  text-white border-0">
                            <a href="">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-3 text-center">
                                            <span class="circle circle-sm bg-primary-light">
                                                <i class="fe fe-16 fe-users text-white mb-0"></i>
                                            </span>
                                        </div>
                                        <div class="col pr-0">
                                            <p class="h5 mb-0 ">MEMBERS</p>
                                            <p class="h6 mb-0">TOTAL : </p>

                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    {{-- interns --}}
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-0">
                            <a href="">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-3 text-center">
                                            <span class="circle circle-sm bg-primary">
                                                <i class="fe fe-16 fe-user-plus text-white mb-0"></i>
                                            </span>
                                        </div>
                                        <div class="col pr-0">
                                            <p class="h5 mb-0 ">INTERNS</p>
                                            <p class="h6 mb-0">TOTAL : </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    

                    {{-- appreciations --}}
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-0">
                            <a href="">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-3 text-center">
                                            <span class="circle circle-sm bg-primary">
                                                <i class="fe fe-16 fe-heart text-white mb-0"></i>

                                            </span>
                                        </div>
                                        <div class="col">
                                            <p class="h5 mb-0 ">APPRECIATIONS</p>
                                            <p class="h6 mb-0">TOTAL : </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    {{-- grievances --}}
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-0">
                            <a href="">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-3 text-center">
                                            <span class="circle circle-sm bg-primary">
                                                <i class="fe fe-16 fe-alert-circle text-white mb-0"></i>
                                            </span>
                                        </div>
                                        <div class="col">
                                            <p class="h5 mb-0">GRIEVANCES</p>
                                            <p class="h6 mb-0">TOTAL : </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    {{-- posts --}}
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-0">
                            <a href="">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-3 text-center">
                                            <span class="circle circle-sm bg-primary">
                                                <i class="fe fe-16 fe-file-text text-white mb-0"></i>
                                            </span>
                                        </div>
                                        <div class="col">
                                            <p class="h5 mb-0">POSTS</p>
                                            <p class="h6 mb-0">TOTAL : </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    {{-- advisory --}}
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-0">
                            <a href="">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-3 text-center">
                                            <span class="circle circle-sm bg-primary">
                                                <i class="fe fe-16 fe-message-circle text-white mb-0"></i>

                                            </span>
                                        </div>
                                        <div class="col">
                                            <p class="h5 mb-0 ">ADVISORY</p>
                                            <p class="h6 mb-0">TOTAL : </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>


                    {{-- referrals --}}
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-0">
                            <a href="">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-3 text-center">
                                            <span class="circle circle-sm bg-primary">
                                                <i class="fe fe-16 fe-link text-white mb-0"></i>
                                            </span>
                                        </div>
                                        <div class="col pr-0">
                                            <p class="h5 mb-0 ">REFERRALS</p>
                                            <p class="h6 mb-0">TOTAL : </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                   

             

                </div>
                <!-- end section -->



            </div>
        </div> <!-- .row -->
    </div>
@endsection
