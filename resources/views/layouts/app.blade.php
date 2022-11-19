<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="./assets/img/favicon.png">
    <title>
        @yield('title')
    </title>
    @stack('before-styles')
    @include('includes.admin.styles')
    @stack('after-styles')
</head>

<body class="g-sidenav-show   bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    @include('includes.admin.sidebar')
    <main class="main-content position-relative border-radius-lg ">
        @include('includes.admin.navbar')
        <div class="container-fluid py-4">
            @yield('content')
            @include('includes.admin.footer')
        </div>
    </main>
    {{-- @include('includes.admin.plugins') --}}

    @include('includes.admin.modal-logout')

    @stack('before-scripts')
    @include('includes.admin.scripts')
    @stack('after-scripts')
</body>

</html>