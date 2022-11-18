<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    @stack('before-styles')
    @include('includes.styles')
    @stack('after-styles')
</head>

<body>

    <div class="site-wrap">
        @include('includes.navbar')

        @include('includes.hero')

        @yield('content')

        @include('includes.footer')
    </div>

    @stack('before-scripts')
    @include('includes.scripts')
    @stack('after-scripts')

</body>

</html>