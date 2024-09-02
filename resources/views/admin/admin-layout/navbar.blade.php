<nav class="topnav navbar navbar-light">





    <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
        <i class="fe fe-menu navbar-toggler-icon"></i>
    </button>




    <ul class="nav">

        <li class="nav-item d-flex align-items-center text-center">

            {{-- @foreach (Auth::user()->roles as $role)
                {{ $role->name }} {{ Auth::user()->name }}
            @endforeach --}}

        </li>


        <li class="nav-item">
            <a class="nav-link text-muted my-2" href="#" id="modeSwitcher" data-mode="light">
                <i class="fe fe-sun fe-16"></i>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink"
                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="circle circle-sm bg-primary">
                    <i class="fe fe-16 fe-user text-white"></i>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="#">Profile</a>
                <a class="dropdown-item" href="#">Settings</a>
                <a class="dropdown-item" href="#">Activities</a>
                <a class="dropdown-item" href="{{ route('admin.logout') }}">Log Out</a>
            </div>
        </li>
    </ul>
</nav>
<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light">
        <!-- nav bar -->
        <div class="w-100 mb-2 d-flex">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="{{ route('admin.dashboard') }}">
                <svg version="1.1" id="logo" class="navbar-brand-img brand-sm" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120"
                    xml:space="preserve">
                    <g>
                        <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                        <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                        <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
                    </g>
                </svg>
            </a>
        </div>
        <ul class="navbar-nav flex-fill w-100 mb-2">

            <li class="nav-item ">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="fe fe-home fe-16"></i>
                    <span class="ml-3 item-text h6">Dashboard</span>
                </a>
            </li>

            <li>
                <hr>
            </li>




            <li class="nav-item ">
                <a href="" class="nav-link">
                    <i class="fe fe-16 fe-users "></i>
                    <span class="ml-3 item-text h6">MEMBERS</span>
                </a>
            </li>



            <li class="nav-item ">
                <a href="" class="nav-link">
                    <i class="fe fe-16 fe-user-plus "></i>
                    <span class="ml-3 item-text h6">INTERNS</span>
                </a>
            </li>





            <li class="nav-item ">
                <a href="" class="nav-link">
                    <i class="fe fe-16 fe-heart "></i>
                    <span class="ml-3 item-text h6">APPRECIATIONS</span>
                </a>
            </li>

            <li class="nav-item ">
                <a href="\" class="nav-link">
                    <i class="fe fe-16 fe-alert-circle "></i>
                    <span class="ml-3 item-text h6">GRIEVANCES</span>
                </a>
            </li>

            <li class="nav-item ">
                <a href="" class="nav-link">
                    <i class="fe fe-16 fe-file-text "></i>
                    <span class="ml-3 item-text h6">POSTS</span>
                </a>
            </li>


            <li class="nav-item ">
                <a href="" class="nav-link">
                    <i class="fe fe-16 fe-message-circle "></i>
                    <span class="ml-3 item-text h6">ADVISORY</span>
                </a>
            </li>

            <li class="nav-item ">
                <a href="" class="nav-link">
                    <i class="fe fe-16 fe-link "></i>
                    <span class="ml-3 item-text h6">REFERRALS</span>
                </a>
            </li>

            <li class="nav-item ">
                <a href="" class="nav-link">
                    <i class="fe fe-16 fe-award "></i>
                    <span class="ml-3 item-text h6">WINNERS</span>
                </a>
            </li>

   

            {{-- <li class="nav-item dropdown">
                    <a href="#roleandpermission" data-toggle="collapse" aria-expanded="false"
                        class="dropdown-toggle nav-link">
                        <i class="fe fe-tool fe-16"></i>
                        <span class="ml-3 item-text h6">Role & Permission</span>
                    </a>
                    <ul class="collapse list-unstyled pl-4 w-100" id="roleandpermission">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href=""><span
                                    class="ml-1 item-text h5">&bull;Roles</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pl-3" href=""><span
                                    class="ml-1 item-text h5">&bull;Permissions
                                </span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pl-3" href=""><span
                                    class="ml-1 item-text h5">&bull;Assign Permission
                                </span></a>
                        </li>
                    </ul>
                </li> --}}



            {{-- <li class="nav-item dropdown">
                    <a href="#layouts" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        <i class="fe fe-layout fe-16"></i>
                        <span class="ml-3 item-text h6">Reports</span>
                    </a>
                    <ul class="collapse list-unstyled pl-4 w-100" id="layouts">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="./index.html"><span class="ml-1 item-text">Daily
                                    Report</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="./index-horizontal.html"><span class="ml-1 item-text">Monthly
                                    Report</span></a>
                        </li>
                    </ul>
                </li> --}}



        </ul>

    </nav>
</aside>



{{-- for current page navigation style --}}
<style>
.nav-item.active {
    background-color: #f0f0f0;
    color: #333;
}
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var currentPath = window.location.href;
        var navbarLinks = document.querySelectorAll('.nav-link');

        console.log(currentPath,navbarLinks);
        // Loop through each navbar link
        navbarLinks.forEach(function(link) {
            if (link.getAttribute('href') === currentPath) {
                link.parentElement.classList.add('active');
            }
            else if (link.getAttribute('href').includes('appreciation') && currentPath.includes('appreciation')) {
                link.parentElement.classList.add('active');
            }
            else if (link.getAttribute('href').includes('grievance') && currentPath.includes('grievance')) {
                link.parentElement.classList.add('active');
            }
            else if (link.getAttribute('href').includes('post') && currentPath.includes('post')) {
                link.parentElement.classList.add('active');
            }
            else if (link.getAttribute('href').includes('advisor') && currentPath.includes('advisor')) {
                link.parentElement.classList.add('active');
            }
            else if (link.getAttribute('href').includes('winner') && currentPath.includes('winner') || link.getAttribute('href').includes('winner') && currentPath.includes('candidates') ) {
                link.parentElement.classList.add('active');
            }
            else if (link.getAttribute('href').includes('banner') && currentPath.includes('banner') ) {
                link.parentElement.classList.add('active');
            }
            else if (link.getAttribute('href').includes('compan') && currentPath.includes('compan') ) {
                link.parentElement.classList.add('active');
            }
        });
    });
</script>
