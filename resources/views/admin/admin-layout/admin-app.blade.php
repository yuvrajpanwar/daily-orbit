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

        /* Preloader Styles */
        #preloader {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-left-color: #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

</head>

<body class="vertical  light  ">
    <div id="preloader">
        <div class="spinner"></div>
    </div>

    <div class="wrapper">

        @include('admin/admin-layout/navbar')

        <main class="main-content pt-0">
            @yield('content')
        </main>

    </div>

    @include('admin/admin-layout/common-js')

    @stack('js')

</body>
<script>
    setTimeout(function() {
        $('#alert-success').addClass('collapse');
        $('#alert-success').removeClass('show');
    }, 4500);
    // Wait for the page to fully load 
    const preloader = document.getElementById('preloader');
    const body = document.querySelector('body');
    window.addEventListener('load', function() {
        // Hide the preloader
        preloader.style.display = 'none';
    });
    $("#modeSwitcher").on("click", function(e) {
        body.style.display = 'none';
    })
</script>

</html>
