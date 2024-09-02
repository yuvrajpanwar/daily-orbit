<html lang="en">

    <head>

    <link rel="shortcut icon" href="{{ asset('img/admin-favicon.png') }}" type="image/x-icon">


        @stack('meta')

        <title>@yield('title', 'Admin Panel')</title>

        @include('admin/admin-layout/common-css')

        @stack('css')


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
        </style>
        
    </head>

    <body class="vertical  light  ">


        <div class="wrapper">

            @include('admin/admin-layout/navbar')  
            
            <main class="main-content pt-0">
                @yield('content')
            </main>

        </div> 

        @include('admin/admin-layout/common-js')

        @stack('js')

    </body>

</html>